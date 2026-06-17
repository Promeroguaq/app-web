<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\ActividadParque;
use App\Models\DeporteAventura;
use App\Models\DesiertoLaguna;
use App\Models\Iglesia;
use App\Models\Imagen;
use App\Models\Isla;
use App\Models\Museo;
use App\Models\ParqueTematico;
use App\Models\Playa;
use App\Models\Termal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DestinosController extends Controller
{
    /**
     * Mostrar página de destinos con filtros y búsqueda
     */
    public function index(Request $request)
    {
        try {
            // Cachear datos base por 1 hora
            $cached = Cache::remember('destinos_index_data', 3600, function () {
                $departamentos = DB::table('tabla_departamentos')
                    ->select('ID_DEPARTAMENTO', 'NOMBRE_DEPARTAMENTO')
                    ->distinct()
                    ->orderBy('NOMBRE_DEPARTAMENTO')
                    ->get();
                    
                $municipios = DB::table('tabla_municipios')
                    ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS', 'ID_LOCALITIES', 'ID_DEPARTAMENTO')
                    ->orderBy('NOMBRE_MUNICIPIOS')
                    ->get();
                    
                $destinos = collect($this->obtenerDestinosDesdeBaseDeDatos());
                
                return ['departamentos' => $departamentos, 'municipios' => $municipios, 'destinos' => $destinos];
            });
            
            $departamentos = $cached['departamentos'];
            $municipios = $cached['municipios'];
            $destinos = $cached['destinos'];

            $categorias = $destinos
                ->pluck('categoria')
                ->unique()
                ->sort()
                ->values()
                ->all();

            if ($request->filled('busqueda')) {
                $destinos = $destinos->filter(function ($destino) use ($request) {
                    return stripos($destino['nombre'], $request->busqueda) !== false ||
                           stripos($destino['descripcion'], $request->busqueda) !== false ||
                           stripos($destino['departamento'], $request->busqueda) !== false ||
                           stripos($destino['municipio'], $request->busqueda) !== false ||
                           stripos($destino['categoria'], $request->busqueda) !== false;
                });
            }

            if ($request->filled('categoria') && $request->categoria !== 'Todas las categorías') {
                $destinos = $destinos->filter(function ($destino) use ($request) {
                    return $destino['categoria'] === $request->categoria;
                });
            }

            // Department filtering with fallback for empty departments table
            if ($request->filled('departamento') && $request->departamento !== 'Todos los departamentos') {
                // If departments table is empty, show all destinations for the category instead of filtering by department
                if (count($departamentos) === 0) {
                    // Don't filter by department since we don't have department data
                    // Just keep the category filtering that was applied above
                    $municipiosFiltro = $municipios->pluck('NOMBRE_MUNICIPIOS')->values()->all();
                } else {
                    // Normal department filtering
                    $destinos = $destinos->filter(function ($destino) use ($request) {
                        return trim($destino['departamento']) === trim($request->departamento);
                    });
                    $municipiosFiltro = $this->obtenerMunicipiosPorDepartamento($request->departamento);
                }
            } else {
                $municipiosFiltro = $municipios->pluck('NOMBRE_MUNICIPIOS')->values()->all();
            }

            if ($request->filled('municipio') && $request->municipio !== 'Todos los municipios') {
                $destinos = $destinos->filter(function ($destino) use ($request) {
                    return $destino['municipio'] === $request->municipio;
                });
            }

            $destinos = $destinos->values()->all();

            return view('pages.destinos', compact(
                'destinos',
                'departamentos',
                'municipios',
                'categorias',
                'municipiosFiltro'
            ));
        } catch (\Exception $e) {
            // Return a simple error view if something goes wrong
            return view('pages.destinos', [
                'destinos' => [],
                'departamentos' => collect([]),
                'municipios' => collect([]),
                'categorias' => [],
                'municipiosFiltro' => [],
                'error' => 'Error al cargar los destinos: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar detalle de un destino específico
     */
    public function show($id)
    {
        // Parsear el ID para determinar la categoría
        $parts = explode('_', $id);
        $categoria = $parts[0];
        $recordId = $parts[1] ?? null;

        $destino = null;

        // Solo manejar actividades en parques ya que es la única tabla que existe
        if ($categoria === 'actividad') {
            $actividad = ActividadParque::find($recordId);
            if ($actividad) {
                $destino = [
                    'id' => $id,
                    'nombre' => $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE,
                    'categoria' => 'Actividad en parque',
                    'subcategoria' => 'Naturaleza',
                    'departamento' => $actividad->DEPARTAMENTO ?? 'Colombia',
                    'municipio' => '',
                    'ubicacion_exacta' => 'Parques naturales de Colombia',
                    'descripcion' => $actividad->DESCRIPCION ?? 'Actividad recreativa en parque natural para conectar con la naturaleza.',
                    'imagen' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=1200&h=600&fit=crop',
                    'calificacion' => 4.6,
                    'destacado' => false
                ];
            }
        }

        if (!$destino) {
            abort(404);
        }

        return view('pages.destino-detalle', compact('destino'));
    }

    private function obtenerDestinosDesdeBaseDeDatos()
    {
        $destinos = [];

        $categorias = [
            ['tabla' => 'tabla_actividad_parque', 'id' => 'ID_ACTIVIDAD', 'nombre' => 'NOMBRE_ACTIVIDAD_EN_PARQUE', 'categoria' => 'Actividad en parque', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITITES', 'prefijo' => 'actividad', 'calificacion' => 4.6],
            ['tabla' => 'tabla_capitales', 'id' => 'ID_CAPITAL', 'nombre' => 'NOMBRE_CAPITAL', 'categoria' => 'Capitales', 'descripcion' => 'DESCRIPCION', 'locality' => null, 'prefijo' => 'capital', 'calificacion' => 4.7],
            ['tabla' => 'tabla_ciclismo', 'id' => 'ID_CICLISMO', 'nombre' => 'NOMBRE_RUTA_CICLISMO', 'categoria' => 'Ciclismo', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'ciclismo', 'calificacion' => 4.6],
            ['tabla' => 'tabla_deporte_aventura', 'id' => 'ID_DEPORTES', 'nombre' => 'NOMBRE_DEPORTES_AVENTURA', 'categoria' => 'Deportes de aventura', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'deporte', 'calificacion' => 4.7],
            ['tabla' => 'tabla_desierto_laguna', 'id' => 'ID_DESIERTO', 'nombre' => 'NOMBRE_DESIERTO_LAGUNAS', 'categoria' => 'Desiertos/Lagunas', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'desierto', 'calificacion' => 4.6],
            ['tabla' => 'tabla_iglesias', 'id' => 'ID_IGLESIA', 'nombre' => 'NOMBRE_IGLESIA', 'categoria' => 'Iglesias', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'iglesia', 'calificacion' => 4.5],
            ['tabla' => 'tabla_islas', 'id' => 'ID_ISLA', 'nombre' => 'NOMBRE_ISLA', 'categoria' => 'Islas', 'descripcion' => 'DESCRIPCION', 'locality' => null, 'prefijo' => 'isla', 'calificacion' => 4.7],
            ['tabla' => 'tabla_museos', 'id' => 'COL 1', 'nombre' => 'NOMBRE_MUSEO', 'categoria' => 'Museos', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'museo', 'calificacion' => 4.8],
            ['tabla' => 'tabla_parque_tematicos', 'id' => 'ID_PARQUES', 'nombre' => 'NOMBRE_PARQUES_TEMÁTICOS', 'categoria' => 'Parques temáticos', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'parque', 'calificacion' => 4.8],
            ['tabla' => 'tabla_playas', 'id' => 'ID_PLAYA', 'nombre' => 'NOMBRE_PLAYA', 'categoria' => 'Playas', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'playa', 'calificacion' => 4.7],
            ['tabla' => 'tabla_reservas', 'id' => 'ID_RESERVAS', 'nombre' => 'NOMBRE_RESERVAS_O_PARQUES', 'categoria' => 'Reservas naturales', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'reserva', 'calificacion' => 4.8],
            ['tabla' => 'tabla_termales', 'id' => 'ID_TERMALES', 'nombre' => 'NOMBRE_TERMAL', 'categoria' => 'Termales', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'termal', 'calificacion' => 4.6],
            ['tabla' => 'tabla_gastronomia', 'id' => 'ID_PLATOS', 'nombre' => 'PLATOS_TIPICOS', 'categoria' => 'Gastronomía', 'descripcion' => 'DESCRIPCION', 'locality' => null, 'prefijo' => 'gastronomia', 'calificacion' => 4.9],
            ['tabla' => 'tabla_regiones', 'id' => 'ID_REGION', 'nombre' => 'NOMBRE_REGION', 'categoria' => 'Regiones', 'descripcion' => 'DESCRIPCION', 'locality' => 'ID_LOCALITIES', 'prefijo' => 'region', 'calificacion' => 4.8],
        ];

        // Use a single query with UNION ALL to get all destinations efficiently
        $unionQuery = $this->buildUnionQuery($categorias);
        
        if ($unionQuery) {
            $results = DB::select($unionQuery);
            
            // Preload all needed data to avoid N+1 queries
            $municipiosCache = $this->preloadMunicipios();
            $imagenesCache = $this->preloadImagenes();
            
            foreach ($results as $registro) {
                $destinos[] = $this->formatearDestinoOptimizado(
                    $registro,
                    $municipiosCache,
                    $imagenesCache
                );
            }
        }

        return $destinos;
    }

    private function buildUnionQuery($categorias)
    {
        $queries = [];
        
        foreach ($categorias as $config) {
            // Escape column names with backticks to handle special characters
            $idField = "`{$config['id']}`";
            $nombreField = "`{$config['nombre']}`";
            $descripcionField = "`{$config['descripcion']}`";
            $localityField = $config['locality'] ? "`{$config['locality']}`" : "NULL";
            
            $selectFields = [
                "'{$config['prefijo']}' as prefijo",
                "$idField as record_id",
                "$nombreField as nombre",
                "'{$config['categoria']}' as categoria",
                "COALESCE($descripcionField, 'Destino turístico registrado en la base de datos.') as descripcion",
                $config['locality'] ? "$localityField as locality_id" : "NULL as locality_id",
                "{$config['calificacion']} as calificacion",
                "'" . (in_array($config['categoria'], ['Capitales', 'Museos', 'Parques temáticos', 'Playas', 'Reservas naturales', 'Islas'], true) ? '1' : '0') . "' as destacado"
            ];
            
            $queries[] = "SELECT " . implode(', ', $selectFields) . " FROM `{$config['tabla']}`";
        }
        
        return implode(' UNION ALL ', $queries);
    }
    
    private function preloadMunicipios()
    {
        return DB::table('tabla_municipios')
            ->select('tabla_municipios.ID_MUNICIPIOS', 'tabla_municipios.NOMBRE_MUNICIPIOS', 'tabla_municipios.ID_LOCALITIES', 'tabla_municipios.ID_LOCALITIES as locality_id', 'tabla_departamentos.NOMBRE_DEPARTAMENTO')
            ->leftJoin('tabla_departamentos', 'tabla_departamentos.ID_DEPARTAMENTO', '=', 'tabla_municipios.ID_DEPARTAMENTO')
            ->get()
            ->keyBy(function($municipio) {
                return $municipio->ID_MUNICIPIOS . '_' . ($municipio->ID_LOCALITIES ?? '');
            });
    }
    
    private function preloadImagenes()
    {
        return Imagen::all()
            ->keyBy('locality_id');
    }
    
    private function formatearDestinoOptimizado($registro, $municipiosCache, $imagenesCache)
    {
        $ubicacion = $this->obtenerUbicacionOptimizada($registro->locality_id, $municipiosCache);
        $imagen = $registro->locality_id ? ($imagenesCache[$registro->locality_id] ?? null) : null;

        return [
            'id' => $registro->prefijo . '_' . $registro->record_id,
            'nombre' => $registro->nombre,
            'categoria' => $registro->categoria,
            'departamento' => trim($ubicacion['departamento']),
            'municipio' => trim($ubicacion['municipio']),
            'descripcion' => $registro->descripcion,
            'imagen' => $imagen ? $imagen->ruta : 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=600&h=400&fit=crop',
            'calificacion' => floatval($registro->calificacion),
            'destacado' => $registro->destacado === '1'
        ];
    }
    
    private function obtenerUbicacionOptimizada($localityId, $municipiosCache)
    {
        if (!$localityId) {
            return [
                'departamento' => 'Colombia',
                'municipio' => ''
            ];
        }

        $municipio = $municipiosCache->first(function($municipio) use ($localityId) {
            return $municipio->ID_MUNICIPIOS == $localityId || 
                   (isset($municipio->ID_LOCALITIES) && $municipio->ID_LOCALITIES == $localityId);
        });

        return [
            'departamento' => $municipio && isset($municipio->nombre_departamento) ? trim($municipio->nombre_departamento) : 'Colombia',
            'municipio' => $municipio ? trim($municipio->NOMBRE_MUNICIPIOS) : ''
        ];
    }

    private function obtenerRegistrosTablaSeguro($tabla, $orden)
    {
        try {
            return DB::table($tabla)->orderBy($orden)->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function formatearDestino($id, $nombre, $categoria, $descripcion, $localityId, $calificacion, $destacado)
    {
        $ubicacion = $this->obtenerUbicacion($localityId);
        $imagen = $localityId ? Imagen::where('locality_id', $localityId)->first() : null;

        return [
            'id' => $id,
            'nombre' => $nombre,
            'categoria' => $categoria,
            'departamento' => trim($ubicacion['departamento']),
            'municipio' => trim($ubicacion['municipio']),
            'descripcion' => $descripcion ?: 'Destino turístico registrado en la base de datos.',
            'imagen' => $imagen ? $imagen->ruta : 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=600&h=400&fit=crop',
            'calificacion' => $calificacion,
            'destacado' => $destacado
        ];
    }

    private function obtenerUbicacion($localityId)
    {
        if (!$localityId) {
            return [
                'departamento' => 'Colombia',
                'municipio' => ''
            ];
        }

        $municipio = Municipio::where('ID_MUNICIPIOS', $localityId)->first()
            ?: Municipio::where('ID_LOCALITIES', $localityId)->first();

        return [
            'departamento' => $municipio && $municipio->departamento ? trim($municipio->departamento->NOMBRE_DEPARTAMENTO) : 'Colombia',
            'municipio' => $municipio ? trim($municipio->NOMBRE_MUNICIPIOS) : ''
        ];
    }

    private function obtenerMunicipiosPorDepartamento($departamento)
    {
        // Find the department ID first
        $depto = DB::table('tabla_departamentos')
            ->where('NOMBRE_DEPARTAMENTO', trim($departamento))
            ->first();
            
        if (!$depto) {
            return [];
        }
        
        // Get municipalities for this department
        return DB::table('tabla_municipios')
            ->where('ID_DEPARTAMENTO', $depto->ID_DEPARTAMENTO)
            ->orderBy('NOMBRE_MUNICIPIOS')
            ->pluck('NOMBRE_MUNICIPIOS')
            ->map(fn ($municipio) => trim($municipio))
            ->values()
            ->all();
    }
}
