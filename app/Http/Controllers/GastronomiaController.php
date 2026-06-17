<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\PlatoTipico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GastronomiaController extends Controller
{
    /**
     * Helper para normalizar texto (eliminar tildes, mayúsculas)
     */
    private function normalizeText($text)
    {
        if (!$text) return '';
        return Str::slug(Str::ascii($text));
    }

    /**
     * Mostrar página principal de gastronomía
     */
    public function index(Request $request)
    {
        $startTime = microtime(true);

        try {
            // Contadores globales (independientes de filtros) - con cache
            $totalPlatos = Cache::remember('count_platos_unicos', 1800, function () {
                return DB::table('tabla_gastronomia')
                    ->whereNotNull('PLATOS_TIPICOS')
                    ->where('PLATOS_TIPICOS', '!=', 'PLATOS_TIPICOS')
                    ->distinct()
                    ->count('ID_PLATOS');
            });

            $totalDepartamentos = Cache::remember('count_departamentos_gastronomia', 1800, function () {
                return DB::table('tabla_gastronomia')
                    ->whereNotNull('DEPARTAMENTO')
                    ->where('DEPARTAMENTO', '!=', 'DEPARTAMENTO')
                    ->distinct()
                    ->count('DEPARTAMENTO');
            });

            $totalCategorias = Cache::remember('count_categorias_gastronomia', 1800, function () {
                return DB::table('tabla_gastronomia')
                    ->whereNotNull('CATEGORIA')
                    ->where('CATEGORIA', '!=', 'CATEGORIA')
                    ->distinct()
                    ->count('CATEGORIA');
            });

            // Obtener departamentos y categorías únicos para los filtros
            $departamentos = DB::table('tabla_gastronomia')
                ->select('DEPARTAMENTO')
                ->whereNotNull('DEPARTAMENTO')
                ->where('DEPARTAMENTO', '!=', 'DEPARTAMENTO')
                ->distinct()
                ->orderBy('DEPARTAMENTO')
                ->pluck('DEPARTAMENTO');

            $categorias = DB::table('tabla_gastronomia')
                ->select('CATEGORIA')
                ->whereNotNull('CATEGORIA')
                ->where('CATEGORIA', '!=', 'CATEGORIA')
                ->distinct()
                ->orderBy('CATEGORIA')
                ->pluck('CATEGORIA');

            // Construir query base con filtros
            $query = DB::table('tabla_gastronomia')
                ->whereNotNull('PLATOS_TIPICOS')
                ->where('PLATOS_TIPICOS', '!=', 'PLATOS_TIPICOS');

            // Aplicar filtros
            $filterDepartment = $request->query('departamento');
            $filterCategory = $request->query('categoria');
            $search = $request->query('buscar');

            if ($filterDepartment) {
                $query->where('DEPARTAMENTO', $filterDepartment);
            }

            if ($filterCategory) {
                $query->where('CATEGORIA', $filterCategory);
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('PLATOS_TIPICOS', 'like', "%{$search}%")
                      ->orWhere('DESCRIPCION', 'like', "%{$search}%")
                      ->orWhere('DEPARTAMENTO', 'like', "%{$search}%");
                });
            }

            // Paginar (12 por página)
            $perPage = 12;
            $page = $request->query('page', 1);
            $offset = ($page - 1) * $perPage;

            $total = $query->count();
            $rawPlatos = $query->offset($offset)->limit($perPage)->get();

            Log::info('Gastronomia page query', [
                'search' => $search,
                'departamento' => $filterDepartment,
                'categoria' => $filterCategory,
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'query_time_ms' => round((microtime(true) - $startTime) * 1000, 2),
            ]);

            // Cargar mapa de imágenes una sola vez para todos los platos de la página
            $imagenesMap = \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();

            // Mapear solo los platos de la página actual (con imágenes, evitando repeticiones)
            $usedImages = [];
            $platos = $rawPlatos->map(function ($row) use (&$usedImages, $imagenesMap) {
                $nombre = trim($row->PLATOS_TIPICOS ?? '');
                $departamento = trim($row->DEPARTAMENTO ?? '');
                $categoria = trim($row->CATEGORIA ?? '');
                $region = trim($row->REGIÓN ?? '');
                $descripcion = trim($row->DESCRIPCION ?? '');

                // Buscar imagen en tabla_imagenes (evitando repeticiones, usando mapa pre-cargado)
                $imagenData = ImageHelper::getGastronomiaImage($nombre, $departamento, $categoria, $usedImages, $imagenesMap);

                // Marcar imagen como usada si se asignó
                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }

                $departmentSlug = $this->normalizeText($departamento);
                $platoSlug = $this->normalizeText($nombre);

                // Log first plato for debugging
                if ($row->ID_PLATOS == 12) {
                    Log::info('Gastronomia card generated for Patacones', [
                        'id' => $row->ID_PLATOS,
                        'nombre' => $nombre,
                        'departamento' => $departamento,
                        'department_slug' => $departmentSlug,
                        'plato_slug' => $platoSlug,
                        'url' => route('gastronomia.show', [
                            'departmentSlug' => $departmentSlug,
                            'platoSlug' => $platoSlug,
                        ]),
                    ]);
                }

                return (object)[
                    'id' => $row->ID_PLATOS,
                    'nombre' => $nombre,
                    'categoria' => $categoria,
                    'departamento' => $departamento,
                    'region' => $region,
                    'descripcion' => $descripcion,
                    'imagen' => $imagenData['url'],
                    'imagen_id' => $imagenData['id'],
                    'match_type' => $imagenData['match_type'],
                    'department_slug' => $departmentSlug,
                    'slug' => $platoSlug,
                ];
            })->filter(fn ($p) => !empty($p->nombre))->values();

            Log::info('Gastronomia total time', [
                'total_time_ms' => round((microtime(true) - $startTime) * 1000, 2),
            ]);

            return view('pages.gastronomia', compact(
                'platos',
                'departamentos',
                'categorias',
                'total',
                'totalPlatos',
                'totalDepartamentos',
                'totalCategorias',
                'perPage',
                'page',
                'search',
                'filterDepartment',
                'filterCategory'
            ));
        } catch (\Exception $e) {
            Log::error('Error en GastronomiaController@index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return view('pages.gastronomia', [
                'platos' => collect([]),
                'departamentos' => collect([]),
                'categorias' => collect([]),
                'total' => 0,
                'totalPlatos' => 0,
                'totalDepartamentos' => 0,
                'totalCategorias' => 0,
                'perPage' => 12,
                'page' => 1,
                'search' => null,
                'filterDepartment' => null,
                'filterCategory' => null,
                'error' => 'Error al cargar la página de gastronomía.'
            ]);
        }
    }

    /**
     * Mostrar detalle de un plato específico
     */
    public function show($departmentSlug, $platoSlug)
    {
        try {
            Log::info('Gastronomia show request', [
                'departmentSlug' => $departmentSlug,
                'platoSlug' => $platoSlug,
            ]);

            // Cargar mapa de imágenes una sola vez
            $imagenesMap = \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();

            // Buscar el plato por slug y departamento usando normalización PHP (consistente con index)
            $allPlatos = DB::table('tabla_gastronomia')
                ->whereNotNull('PLATOS_TIPICOS')
                ->where('PLATOS_TIPICOS', '!=', 'PLATOS_TIPICOS')
                ->get();

            $row = $allPlatos->first(function ($item) use ($departmentSlug, $platoSlug) {
                $itemDepartmentSlug = $this->normalizeText($item->DEPARTAMENTO ?? '');
                $itemPlatoSlug = $this->normalizeText($item->PLATOS_TIPICOS ?? '');
                return $itemDepartmentSlug === $departmentSlug && $itemPlatoSlug === $platoSlug;
            });

            if (!$row) {
                Log::warning('Gastronomia plato not found', [
                    'departmentSlug' => $departmentSlug,
                    'platoSlug' => $platoSlug,
                    'total_platos' => $allPlatos->count(),
                ]);
                abort(404);
            }

            $nombre = trim($row->PLATOS_TIPICOS ?? '');
            $departamento = trim($row->DEPARTAMENTO ?? '');
            $categoria = trim($row->CATEGORIA ?? '');

            $imagenData = ImageHelper::getGastronomiaImage($nombre, $departamento, $categoria, [], $imagenesMap);

            // Cargar detalle de receta si existe
            $detalle = DB::table('detalle_platos')
                ->where('plato_id', $row->ID_PLATOS)
                ->first();

            // Cargar ingredientes si el detalle está publicado
            $ingredientes = [];
            if ($detalle && $detalle->estado_verificacion === 'publicado') {
                $ingredientes = DB::table('ingredientes_platos')
                    ->where('plato_id', $row->ID_PLATOS)
                    ->orderBy('orden')
                    ->get();
            }

            // Cargar pasos de preparación si el detalle está publicado
            $pasos = [];
            if ($detalle && $detalle->estado_verificacion === 'publicado') {
                $pasos = DB::table('pasos_preparacion')
                    ->where('plato_id', $row->ID_PLATOS)
                    ->orderBy('orden')
                    ->get();
            }

            $plato = (object)[
                'id' => $row->ID_PLATOS,
                'nombre' => $nombre,
                'categoria' => $categoria,
                'departamento' => $departamento,
                'region' => trim($row->REGIÓN ?? ''),
                'descripcion' => trim($row->DESCRIPCION ?? ''),
                'imagen' => $imagenData['url'],
                'imagen_id' => $imagenData['id'],
                'match_type' => $imagenData['match_type'],
                'department_slug' => $this->normalizeText($departamento),
                'slug' => $this->normalizeText($nombre),
                'detalle' => $detalle,
                'ingredientes' => $ingredientes,
                'pasos' => $pasos,
            ];

            // Cargar platos relacionados del mismo departamento (evitando repeticiones)
            $usedImages = [$plato->imagen]; // Excluir imagen del plato principal
            $relatedRows = DB::table('tabla_gastronomia')
                ->where('DEPARTAMENTO', $plato->departamento)
                ->where('ID_PLATOS', '!=', $plato->id)
                ->whereNotNull('PLATOS_TIPICOS')
                ->where('PLATOS_TIPICOS', '!=', 'PLATOS_TIPICOS')
                ->take(6)
                ->get();

            $relatedPlatos = $relatedRows->map(function ($row) use (&$usedImages, $imagenesMap) {
                $nombre = trim($row->PLATOS_TIPICOS ?? '');
                $departamento = trim($row->DEPARTAMENTO ?? '');
                $categoria = trim($row->CATEGORIA ?? '');

                $imagenData = ImageHelper::getGastronomiaImage($nombre, $departamento, $categoria, $usedImages, $imagenesMap);

                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }

                return (object)[
                    'id' => $row->ID_PLATOS,
                    'nombre' => $nombre,
                    'categoria' => $categoria,
                    'departamento' => $departamento,
                    'imagen' => $imagenData['url'],
                    'imagen_id' => $imagenData['id'],
                    'match_type' => $imagenData['match_type'],
                    'department_slug' => $this->normalizeText($departamento),
                    'slug' => $this->normalizeText($nombre),
                ];
            })->values();

            return view('pages.gastronomia-detalle', compact('plato', 'relatedPlatos'));
        } catch (\Exception $e) {
            Log::error('Error en GastronomiaController@show', [
                'error' => $e->getMessage(),
                'departmentSlug' => $departmentSlug,
                'platoSlug' => $platoSlug,
            ]);
            abort(404);
        }
    }
}
