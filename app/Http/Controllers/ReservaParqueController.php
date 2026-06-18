<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\ReservaParque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ReservaParqueController extends Controller
{
    /**
     * Helper para normalizar texto
     */
    private function normalizeText($text)
    {
        if (!$text) return '';
        return Str::slug($text);
    }

    /**
     * Mostrar página principal de reservas y parques
     */
    public function index(Request $request)
    {
        $startTime = microtime(true);

        try {
            // Cargar mapa de regiones una sola vez (cacheado)
            $regionesMap = Cache::remember('regiones_map', 1800, function () {
                return DB::table('tabla_regiones')
                    ->select('ID_REGION', 'NOMBRE_REGION')
                    ->get()
                    ->keyBy('ID_REGION');
            });

            // Cargar mapa de municipios una sola vez (cacheado)
            $municipiosMap = Cache::remember('municipios_map', 1800, function () {
                return DB::table('tabla_municipios')
                    ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS')
                    ->get()
                    ->keyBy('ID_MUNICIPIOS');
            });

            // Obtener regiones únicas con nombres
            $regiones = DB::table('tabla_reservas')
                ->select('ID_REGIÓN')
                ->whereNotNull('ID_REGIÓN')
                ->distinct()
                ->orderBy('ID_REGIÓN')
                ->pluck('ID_REGIÓN')
                ->map(function($id) use ($regionesMap) {
                    return $regionesMap->get($id) ? $regionesMap->get($id)->NOMBRE_REGION : $id;
                });

            // Obtener localidades únicas con nombres
            $localidades = DB::table('tabla_reservas')
                ->select('ID_LOCALITIES')
                ->whereNotNull('ID_LOCALITIES')
                ->distinct()
                ->orderBy('ID_LOCALITIES')
                ->pluck('ID_LOCALITIES')
                ->map(function($id) use ($municipiosMap) {
                    return $municipiosMap->get($id) ? $municipiosMap->get($id)->NOMBRE_MUNICIPIOS : $id;
                });

            // Construir query base con filtros
            $query = DB::table('tabla_reservas')
                ->whereNotNull('NOMBRE_RESERVAS_O_PARQUES')
                ->where('NOMBRE_RESERVAS_O_PARQUES', '!=', 'NOMBRE_RESERVAS_O_PARQUES');

            // Aplicar filtros
            $search = $request->query('buscar');
            $filterRegion = $request->query('region');
            $filterLocality = $request->query('locality');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('NOMBRE_RESERVAS_O_PARQUES', 'like', "%{$search}%")
                      ->orWhere('DESCRIPCION', 'like', "%{$search}%");
                });
            }

            if ($filterRegion) {
                // Buscar ID de región por nombre
                $regionId = $regionesMap->search(function($region) use ($filterRegion) {
                    return $region->NOMBRE_REGION === $filterRegion;
                });
                if ($regionId !== false) {
                    $query->where('ID_REGIÓN', $regionId);
                }
            }

            if ($filterLocality) {
                // Buscar ID de municipio por nombre
                $municipioId = $municipiosMap->search(function($municipio) use ($filterLocality) {
                    return $municipio->NOMBRE_MUNICIPIOS === $filterLocality;
                });
                if ($municipioId !== false) {
                    $query->where('ID_LOCALITIES', $municipioId);
                }
            }

            // Paginar (12 por página)
            $perPage = 12;
            $page = $request->query('page', 1);
            $offset = ($page - 1) * $perPage;

            $total = $query->count();
            $rawReservas = $query->offset($offset)->limit($perPage)->get();

            // Cargar mapa de imágenes una sola vez - CACHED
            $imagenesMap = Cache::remember('imagenes_map_global', 1800, function () {
                return DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });

            // Mapear reservas con imágenes, regiones y municipios (evitando repeticiones)
            $usedImages = [];
            $reservas = $rawReservas->map(function ($row) use (&$usedImages, $imagenesMap, $regionesMap, $municipiosMap) {
                $nombre = trim($row->NOMBRE_RESERVAS_O_PARQUES ?? '');
                $descripcion = trim($row->DESCRIPCION ?? '');
                $localityId = $row->ID_LOCALITIES ?? null;
                $regionId = $row->ID_REGIÓN ?? null;

                // Resolver nombres reales
                $localidadNombre = null;
                if ($localityId && isset($municipiosMap[$localityId])) {
                    $localidadNombre = $municipiosMap[$localityId]->NOMBRE_MUNICIPIOS;
                }

                $regionNombre = null;
                if ($regionId && isset($regionesMap[$regionId])) {
                    $regionNombre = $regionesMap[$regionId]->NOMBRE_REGION;
                }

                // Buscar imagen
                $imagenData = ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);

                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }

                return (object)[
                    'id' => $row->ID_RESERVAS,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'locality_id' => $localityId,
                    'region_id' => $regionId,
                    'localidad' => $localidadNombre,
                    'region' => $regionNombre,
                    'imagen' => $imagenData['url'],
                    'imagen_id' => $imagenData['id'],
                    'match_type' => $imagenData['match_type'],
                    'slug' => $this->normalizeText($nombre),
                ];
            })->filter(fn ($r) => !empty($r->nombre))->values();

            Log::info('Reservas parques index cargado', [
                'total' => $total,
                'items_count' => $reservas->count(),
                'regiones_count' => $regiones->count(),
                'localidades_count' => $localidades->count()
            ]);

            return view('pages.reservas-parques', compact(
                'reservas',
                'regiones',
                'localidades',
                'total',
                'perPage',
                'page'
            ));
        } catch (\Exception $e) {
            Log::error('Error en ReservaParqueController@index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return view('pages.reservas-parques', [
                'reservas' => collect([]),
                'regiones' => collect([]),
                'localidades' => collect([]),
                'total' => 0,
                'perPage' => 12,
                'page' => 1,
                'error' => 'Error al cargar la página de reservas y parques.'
            ]);
        }
    }

    /**
     * Mostrar detalle de una reserva/parque
     */
    public function show($id)
    {
        try {
            // Cargar mapa de regiones una sola vez (cacheado)
            $regionesMap = Cache::remember('regiones_map', 1800, function () {
                return DB::table('tabla_regiones')
                    ->select('ID_REGION', 'NOMBRE_REGION')
                    ->get()
                    ->keyBy('ID_REGION');
            });

            // Cargar mapa de municipios una sola vez (cacheado)
            $municipiosMap = Cache::remember('municipios_map', 1800, function () {
                return DB::table('tabla_municipios')
                    ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS')
                    ->get()
                    ->keyBy('ID_MUNICIPIOS');
            });

            // Cargar mapa de imágenes una sola vez - CACHED
            $imagenesMap = Cache::remember('imagenes_map_global', 1800, function () {
                return DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });

            // Buscar la reserva por ID
            $row = DB::table('tabla_reservas')
                ->where('ID_RESERVAS', $id)
                ->whereNotNull('NOMBRE_RESERVAS_O_PARQUES')
                ->where('NOMBRE_RESERVAS_O_PARQUES', '!=', 'NOMBRE_RESERVAS_O_PARQUES')
                ->first();

            if (!$row) {
                Log::warning('Reserva parque no encontrado', ['id' => $id]);
                abort(404);
            }

            $nombre = trim($row->NOMBRE_RESERVAS_O_PARQUES ?? '');
            $descripcion = trim($row->DESCRIPCION ?? '');
            $localityId = $row->ID_LOCALITIES ?? null;
            $regionId = $row->ID_REGIÓN ?? null;

            // Resolver nombres reales
            $localidadNombre = null;
            if ($localityId && isset($municipiosMap[$localityId])) {
                $localidadNombre = $municipiosMap[$localityId]->NOMBRE_MUNICIPIOS;
            }

            $regionNombre = null;
            if ($regionId && isset($regionesMap[$regionId])) {
                $regionNombre = $regionesMap[$regionId]->NOMBRE_REGION;
            }

            $imagenData = ImageHelper::getReservaParqueImage($nombre, [], $imagenesMap);

            $reserva = (object)[
                'id' => $row->ID_RESERVAS,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'locality_id' => $localityId,
                'region_id' => $regionId,
                'localidad' => $localidadNombre,
                'region' => $regionNombre,
                'imagen' => $imagenData['url'],
                'imagen_id' => $imagenData['id'],
                'match_type' => $imagenData['match_type'],
                'slug' => $this->normalizeText($nombre),
            ];

            // Cargar reservas relacionadas (evitando repeticiones)
            $usedImages = [$reserva->imagen];
            $relatedRows = DB::table('tabla_reservas')
                ->where('ID_RESERVAS', '!=', $reserva->id)
                ->whereNotNull('NOMBRE_RESERVAS_O_PARQUES')
                ->where('NOMBRE_RESERVAS_O_PARQUES', '!=', 'NOMBRE_RESERVAS_O_PARQUES')
                ->take(4)
                ->get();

            $relatedReservas = $relatedRows->map(function ($row) use (&$usedImages, $imagenesMap, $regionesMap, $municipiosMap) {
                $nombre = trim($row->NOMBRE_RESERVAS_O_PARQUES ?? '');
                $descripcion = trim($row->DESCRIPCION ?? '');
                $localityId = $row->ID_LOCALITIES ?? null;
                $regionId = $row->ID_REGIÓN ?? null;

                // Resolver nombres reales
                $localidadNombre = null;
                if ($localityId && isset($municipiosMap[$localityId])) {
                    $localidadNombre = $municipiosMap[$localityId]->NOMBRE_MUNICIPIOS;
                }

                $regionNombre = null;
                if ($regionId && isset($regionesMap[$regionId])) {
                    $regionNombre = $regionesMap[$regionId]->NOMBRE_REGION;
                }

                $imagenData = ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);

                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }

                return (object)[
                    'id' => $row->ID_RESERVAS,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'locality_id' => $localityId,
                    'region_id' => $regionId,
                    'localidad' => $localidadNombre,
                    'region' => $regionNombre,
                    'imagen' => $imagenData['url'],
                    'imagen_id' => $imagenData['id'],
                    'match_type' => $imagenData['match_type'],
                    'slug' => $this->normalizeText($nombre),
                ];
            })->values();

            Log::info('Reserva parque show solicitado', [
                'id' => $id,
                'nombre' => $reserva->nombre,
                'relacionados_count' => $relatedReservas->count()
            ]);

            return view('pages.reservas-parques-detalle', compact('reserva', 'relatedReservas'));
        } catch (\Exception $e) {
            Log::error('Error en ReservaParqueController@show', [
                'error' => $e->getMessage(),
                'id' => $id,
            ]);
            abort(404);
        }
    }

    // API methods (keep for backward compatibility)
    public function store(Request $request)
    {
        $data = $request->validate([
            'NOMBRE_RESERVAS_O_PARQUES' => 'required|string',
            'ID_LOCALITIES' => 'required|integer',
            'DESCRIPCION' => 'nullable|string',
            'ID_REGIÓN' => 'required|integer',
        ]);

        return ReservaParque::create($data);
    }

    public function update(Request $request, $id)
    {
        $reserva = ReservaParque::findOrFail($id);
        $reserva->update($request->all());
        return $reserva;
    }

    public function destroy($id)
    {
        ReservaParque::findOrFail($id)->delete();
        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
