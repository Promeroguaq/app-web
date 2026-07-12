<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MunicipioController extends Controller
{
    /**
     * Helper para normalizar texto (eliminar tildes, mayúsculas)
     */
    private function normalizeText($text)
    {
        if (!$text) return '';
        // Use Laravel's Str::slug for proper slug generation
        return \Illuminate\Support\Str::slug($text);
    }

    /**
     * Cargar categorías de puntos de interés para un municipio desde BD
     */
    private function loadMunicipalityCategories($municipioId, $municipioNombre, $departamentoNombre)
    {
        $categorias = [];

        // Tablas de categorías disponibles en BD
        $categoryTables = [
            'playas' => 'Playas',
            'museos' => 'Museos',
            'iglesias' => 'Iglesias',
            'parques_tematicos' => 'Parques Temáticos',
            'termales' => 'Termales',
            'deportes_aventura' => 'Deportes de Aventura',
            'ciclismo' => 'Ciclismo',
            'desiertos_lagunas' => 'Desiertos y Lagunas',
            'islas' => 'Islas',
        ];

        foreach ($categoryTables as $table => $displayName) {
            try {
                // Intentar cargar datos de la tabla
                $items = \DB::table($table)
                    ->where('locality_id', $municipioId)
                    ->get();

                if ($items->count() > 0) {
                    $categorias[$table] = $items->map(function($item) use ($table, $municipioNombre, $departamentoNombre) {
                        return (object)[
                            'id' => $item->id,
                            'nombre' => $item->nombre,
                            'descripcion' => $item->descripcion ?? 'Descubre este lugar increíble en ' . $municipioNombre,
                            'categoria' => $displayName,
                            'imagen' => null,
                            'slug' => $this->normalizeText($item->nombre),
                        ];
                    })->toArray();
                }
            } catch (\Exception $e) {
                // Si la tabla no existe o hay error, continuar con la siguiente
                \Log::warning("Error cargando categoría {$table}: " . $e->getMessage());
            }
        }

        // Si no hay datos específicos del municipio, usar fallback del departamento
        if (empty($categorias)) {
            $categorias = $this->loadDepartmentCategoriesFallback($departamentoNombre);
        }

        return $categorias;
    }

    /**
     * Fallback: cargar categorías del departamento cuando el municipio no tiene datos
     */
    private function loadDepartmentCategoriesFallback($departamentoNombre)
    {
        $categorias = [];
        $normalizedDept = $this->normalizeText($departamentoNombre);

        // Datos contextuales por departamento para fallback
        $departmentFallbacks = [
            'atlantico' => [
                'gastronomia' => [
                    (object)['nombre' => 'Butifarra Soledeña', 'descripcion' => 'Embutido tradicional del Atlántico', 'categoria' => 'Gastronomía', 'imagen' => null, 'slug' => 'butifarra-soledena'],
                    (object)['nombre' => 'Arroz de Lisa', 'descripcion' => 'Plato de pescado con arroz', 'categoria' => 'Gastronomía', 'imagen' => null, 'slug' => 'arroz-de-lisa'],
                ],
                'playas' => [
                    (object)['nombre' => 'Playa de Barranquilla', 'descripcion' => 'Playa cerca del río Magdalena', 'categoria' => 'Playas', 'imagen' => null, 'slug' => 'playa-barranquilla'],
                ],
            ],
            'antioquia' => [
                'gastronomia' => [
                    (object)['nombre' => 'Bandeja Paisa', 'descripcion' => 'Plato típico antioqueño', 'categoria' => 'Gastronomía', 'imagen' => null, 'slug' => 'bandeja-paisa'],
                    (object)['nombre' => 'Arepas Antioqueñas', 'descripcion' => 'Arepas con queso', 'categoria' => 'Gastronomía', 'imagen' => null, 'slug' => 'arepas-antioquenas'],
                ],
            ],
        ];

        // Buscar fallback del departamento
        foreach ($departmentFallbacks as $deptSlug => $deptCategories) {
            if (strpos($normalizedDept, $deptSlug) !== false) {
                return $deptCategories;
            }
        }

        return $categorias;
    }

    /**
     * Obtener lista de departamentos únicos
     */
    private function getDepartments()
    {
        $departamentos = \DB::table('tabla_departamentos')
            ->orderBy('NOMBRE_DEPARTAMENTO')
            ->get()
            ->map(function($depto) {
                return [
                    'id' => $depto->ID_DEPARTAMENTO,
                    'name' => $depto->NOMBRE_DEPARTAMENTO,
                    'slug' => $this->normalizeText($depto->NOMBRE_DEPARTAMENTO)
                ];
            })
            ->unique('slug') // Deduplicar por slug normalizado
            ->values()
            ->sortBy('name')
            ->values();
        
        // Log para verificar departamentos únicos
        \Log::info('Departamentos cargados para filtro', [
            'total_raw' => \DB::table('tabla_departamentos')->count(),
            'total_unique' => $departamentos->count(),
            'departamentos' => $departamentos->pluck('name')->toArray()
        ]);
        
        return $departamentos;
    }

    /**
     * Obtener lista de regiones únicas
     */
    private function getRegions()
    {
        // La columna REGION no existe en la tabla, retornar array vacío
        return collect([]);
    }

    /**
     * Mostrar todos los municipios con búsqueda y filtros
     */
    public function index(Request $request)
    {
        try {
            \Log::info("Cargando página de municipios");
            
            $perPage = $request->get('per_page', 12);
            $page = $request->get('page', 1);
            
            // Verificar si las tablas tienen datos
            $municipiosCount = \DB::table('tabla_municipios')->count();
            $departamentosCount = \DB::table('tabla_departamentos')->count();
            
            \Log::info("Municipios en BD: " . $municipiosCount);
            \Log::info("Departamentos en BD: " . $departamentosCount);
            
            // Cargar municipios desde tabla_municipios
            $query = \DB::table('tabla_municipios as m')
                ->select([
                    'm.ID as id',
                    'm.NOMBRE_MUNICIPIOS as nombre',
                    'm.DESCRIPCION as descripcion',
                    'm.ID_LOCALITIES as localities_id',
                ]);
            
            // Aplicar filtro de búsqueda normalizada
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $normalizedSearch = $this->normalizeText($searchTerm);
                
                $query->where(function($q) use ($searchTerm, $normalizedSearch) {
                    // Búsqueda por nombre (con y sin normalizar)
                    $q->where('m.NOMBRE_MUNICIPIOS', 'like', '%' . $searchTerm . '%')
                      ->orWhere('m.DESCRIPCION', 'like', '%' . $searchTerm . '%');
                    
                    // Búsqueda normalizada (para tildes y mayúsculas)
                    if ($normalizedSearch) {
                        $q->orWhereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(m.NOMBRE_MUNICIPIOS), 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u') LIKE ?", ['%' . $normalizedSearch . '%']);
                    }
                });
            }
            
            // Filtro por departamento
            if ($request->has('departamento') && !empty($request->departamento)) {
                $departamentoSlug = $request->departamento;
                $departamentos = $this->getDepartments();
                $departamento = $departamentos->firstWhere('slug', $departamentoSlug);

                if ($departamento) {
                    // Filtrar por departamento usando subquery con tabla_localities
                    $query->whereExists(function ($query) use ($departamento) {
                        $query->select(\DB::raw(1))
                            ->from('tabla_localities as l')
                            ->whereRaw('LOWER(TRIM(l.MUNICIPIOS)) = LOWER(TRIM(m.NOMBRE_MUNICIPIOS))')
                            ->where('l.DEPARTAMENTO', $departamento['name']);
                    });
                }
            }
            
            // Filtro por región (desactivado ya que la columna no existe en la BD)
            // if ($request->has('region') && !empty($request->region)) {
            //     $query->where('tabla_departamentos.REGION', $request->region);
            // }
            
            // Obtener total de resultados para contador
            $total = $query->count();
            
            // Aplicar paginación
            $municipios = $query
                ->orderBy('m.NOMBRE_MUNICIPIOS')
                ->offset(($page - 1) * $perPage)
                ->limit($perPage)
                ->get();
            
            // Cargar imágenes una sola vez en memoria para evitar consultas repetidas
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')->get();
            });
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });
            
            \Log::info('Imágenes cargadas en memoria', [
                'total_imagenes' => $imagenes->count(),
                'total_unicas_por_nombre' => $imagenesPorNombre->count()
            ]);
            
            // Normalizar datos de municipios
            // Resolver departamento buscando por nombre en tabla_localities con múltiples estrategias
            $municipios_normalizados = $municipios->map(function($municipio) use ($imagenesPorNombre) {
                $nombreMunicipio = $municipio->nombre;
                
                // Estrategia 1: Coincidencia exacta normalizada
                $nombreDepartamento = null;
                $nombreRegion = null;
                
                $locality = \DB::table('tabla_localities')
                    ->whereRaw('LOWER(TRIM(MUNICIPIOS)) = LOWER(TRIM(?))', [$nombreMunicipio])
                    ->first();
                
                // Estrategia 2: Si no hay coincidencia, intentar quitando paréntesis
                if (!$locality && preg_match('/^(.*?)\s*\([^)]*\)$/', $nombreMunicipio, $matches)) {
                    $nombreSinParentesis = trim($matches[1]);
                    $locality = \DB::table('tabla_localities')
                        ->whereRaw('LOWER(TRIM(MUNICIPIOS)) = LOWER(TRIM(?))', [$nombreSinParentesis])
                        ->first();
                }
                
                // Estrategia 3: Si no hay coincidencia, intentar búsqueda aproximada
                if (!$locality) {
                    $nombreParaBusqueda = preg_replace('/\s*\([^)]*\)/', '', $nombreMunicipio);
                    $nombreParaBusqueda = trim($nombreParaBusqueda);
                    
                    if (strlen($nombreParaBusqueda) >= 4) {
                        $locality = \DB::table('tabla_localities')
                            ->whereRaw('LOWER(TRIM(MUNICIPIOS)) LIKE LOWER(TRIM(?))', [$nombreParaBusqueda . '%'])
                            ->first();
                    }
                }
                
                // Estrategia 4: Fallback a ID_LOCALITIES si existe (último recurso)
                if (!$locality && !empty($municipio->localities_id)) {
                    $locality = \DB::table('tabla_localities')
                        ->where('ID', $municipio->localities_id)
                        ->first();
                }
                
                if ($locality) {
                    $nombreDepartamento = $locality->DEPARTAMENTO;
                    $nombreRegion = $locality->REGION;
                }

                $imagen = ImageHelper::getMunicipioImage($nombreMunicipio, $nombreDepartamento, $imagenesPorNombre);

                return (object)[
                    'id' => $municipio->id,
                    'nombre' => $nombreMunicipio,
                    'descripcion' => $municipio->descripcion,
                    'localities_id' => $municipio->localities_id,
                    'departamento' => $nombreDepartamento,
                    'region' => $nombreRegion,
                    'imagen' => $imagen,
                    'slug' => $this->normalizeText($nombreMunicipio),
                    'departamento_slug' => $this->normalizeText($nombreDepartamento ?? '')
                ];
            });
            
            \Log::info("Municipios cargados", [
                'total_raw' => $municipios->count(),
                'total_mapped' => $municipios_normalizados->count(),
                'page' => $page,
                'per_page' => $perPage,
                'total_filtered' => $total
            ]);
            
            if ($municipios_normalizados->count() > 0) {
                \Log::info("Primer municipio ID: " . $municipios_normalizados->first()->id . ", Nombre: " . $municipios_normalizados->first()->nombre . ", Departamento: " . ($municipios_normalizados->first()->departamento ?? 'N/A'));
            }

            return view('pages.municipios', [
                'items' => $municipios_normalizados,
                'search' => $request->search ?? '',
                'departamento' => $request->departamento ?? '',
                'region' => $request->region ?? '',
                'departamentos' => $this->getDepartments(),
                'regiones' => $this->getRegions(),
                'total' => $total,
                'page' => $page,
                'perPage' => $perPage,
                'hasMore' => ($page * $perPage) < $total
            ]);
        } catch (\Exception $e) {
            \Log::error("Error en MunicipioController@index: " . $e->getMessage());
            return view('pages.municipios', [
                'items' => collect([]),
                'error' => 'La tabla de municipios no está disponible en este momento.',
                'search' => $request->search ?? '',
                'departamento' => $request->departamento ?? '',
                'region' => $request->region ?? '',
                'departamentos' => collect([]),
                'regiones' => collect([]),
                'total' => 0,
                'page' => 1,
                'perPage' => $perPage ?? 12,
                'hasMore' => false
            ]);
        }
    }

    /**
     * Mostrar un municipio específico
     */
    public function show($id)
    {
        \Log::info("Intentando cargar municipio con ID: " . $id);

        // NOTA: tabla_municipios tiene ID (no ID_MUNICIPIOS) e ID_LOCALITIES (no ID_DEPARTAMENTO)
        $municipio = \DB::table('tabla_municipios')
            ->where('ID', $id)
            ->first();

        if (!$municipio) {
            \Log::error("Municipio no encontrado con ID: " . $id);
            abort(404);
        }

        // Obtener nombre del departamento desde tabla_localities
        $departamento_nombre = 'Colombia';
        if (!empty($municipio->ID_LOCALITIES)) {
            $locality = \DB::table('tabla_localities')
                ->where('ID', $municipio->ID_LOCALITIES)
                ->first();
            if ($locality) {
                $departamento_nombre = $locality->DEPARTAMENTO;
            }
        }

        // Obtener imagen usando ImageHelper
        $imagen = ImageHelper::getMunicipioImage($municipio->NOMBRE_MUNICIPIOS, $departamento_nombre);

        // Generar slugs para URLs
        $departmentSlug = $this->normalizeText($departamento_nombre);
        $municipalitySlug = $this->normalizeText($municipio->NOMBRE_MUNICIPIOS);

        // Cargar categorías de puntos de interés desde BD
        $categorias = $this->loadMunicipalityCategories($municipio->ID, $municipio->NOMBRE_MUNICIPIOS, $departamento_nombre);

        // Cargar experiencias locales contextuales
        $experienciasLocales = \App\Helpers\LocalExperienceResolver::forMunicipality(
            $municipio->NOMBRE_MUNICIPIOS,
            $departamento_nombre,
            $municipio->ID_LOCALITIES
        );

        $item = (object)[
            'id' => $municipio->ID,
            'nombre' => $municipio->NOMBRE_MUNICIPIOS,
            'descripcion' => $municipio->DESCRIPCION ?? 'Sin descripción',
            'localities_id' => $municipio->ID_LOCALITIES,
            'departamento_nombre' => $departamento_nombre,
            'imagen' => $imagen,
            'slug' => $municipalitySlug,
            'departamento_slug' => $departmentSlug,
            'categorias' => $categorias,
            'experiencias_locales' => $experienciasLocales
        ];

        return view('pages.detalle-municipio', compact('item'))->with('tipo', 'Municipio');
    }

    /**
     * Mostrar un municipio por slugs (departmentSlug/municipalitySlug)
     */
    public function showBySlugs($departmentSlug, $municipalitySlug)
    {
        \Log::info('Buscando municipio por slugs', [
            'departmentSlug' => $departmentSlug,
            'municipalitySlug' => $municipalitySlug,
        ]);

        // Buscar municipio por slug del nombre en tabla_municipios
        $municipio = \DB::table('tabla_municipios')
            ->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(NOMBRE_MUNICIPIOS), 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u') = ?", [$municipalitySlug])
            ->first();

        if (!$municipio) {
            \Log::warning('Municipio no encontrado en showBySlugs', [
                'municipalitySlug' => $municipalitySlug,
            ]);
            abort(404);
        }

        // Obtener departamento de tabla_localities por coincidencia de nombre con múltiples estrategias
        $nombreDepartamento = null;
        $nombreRegion = null;
        
        // Estrategia 1: Coincidencia exacta normalizada
        $locality = \DB::table('tabla_localities')
            ->whereRaw('LOWER(TRIM(MUNICIPIOS)) = LOWER(TRIM(?))', [$municipio->NOMBRE_MUNICIPIOS])
            ->first();
        
        // Estrategia 2: Si no hay coincidencia, intentar quitando paréntesis
        if (!$locality && preg_match('/^(.*?)\s*\([^)]*\)$/', $municipio->NOMBRE_MUNICIPIOS, $matches)) {
            $nombreSinParentesis = trim($matches[1]);
            $locality = \DB::table('tabla_localities')
                ->whereRaw('LOWER(TRIM(MUNICIPIOS)) = LOWER(TRIM(?))', [$nombreSinParentesis])
                ->first();
        }
        
        // Estrategia 3: Si no hay coincidencia, intentar búsqueda aproximada
        if (!$locality) {
            $nombreParaBusqueda = preg_replace('/\s*\([^)]*\)/', '', $municipio->NOMBRE_MUNICIPIOS);
            $nombreParaBusqueda = trim($nombreParaBusqueda);
            
            if (strlen($nombreParaBusqueda) >= 4) {
                $locality = \DB::table('tabla_localities')
                    ->whereRaw('LOWER(TRIM(MUNICIPIOS)) LIKE LOWER(TRIM(?))', [$nombreParaBusqueda . '%'])
                    ->first();
            }
        }
        
        // Estrategia 4: Fallback a ID_LOCALITIES si existe (último recurso)
        if (!$locality && !empty($municipio->ID_LOCALITIES)) {
            $locality = \DB::table('tabla_localities')
                ->where('ID', $municipio->ID_LOCALITIES)
                ->first();
        }
        
        if ($locality) {
            $nombreDepartamento = $locality->DEPARTAMENTO;
            $nombreRegion = $locality->REGION;
        }

        $nombreMunicipio = $municipio->NOMBRE_MUNICIPIOS;

        \Log::info('Municipio encontrado por slugs', [
            'municipioId' => $municipio->ID,
            'municipio' => $nombreMunicipio,
            'departamento' => $nombreDepartamento ?? 'No disponible',
            'region' => $nombreRegion ?? 'No disponible',
        ]);

        // Obtener imagen usando ImageHelper
        $imagen = ImageHelper::getMunicipioImage($nombreMunicipio, $nombreDepartamento);

        // Cargar categorías de puntos de interés desde BD
        $categorias = $this->loadMunicipalityCategories($municipio->ID, $nombreMunicipio, $nombreDepartamento ?? 'Colombia');

        // Cargar experiencias locales contextuales
        $experienciasLocales = \App\Helpers\LocalExperienceResolver::forMunicipality(
            $nombreMunicipio,
            $nombreDepartamento ?? 'Colombia',
            $municipio->ID_LOCALITIES
        );

        // Cargar reviews del municipio
        $municipioModel = \App\Models\Municipio::find($municipio->ID);
        $reviews = $municipioModel ? $municipioModel->reviews()->approved()->latest()->get() : collect();
        $averageRating = $municipioModel ? $municipioModel->averageRating() : 0;
        $reviewsCount = $municipioModel ? $municipioModel->reviewsCount() : 0;

        // Cargar mapa de imágenes una sola vez para platos típicos - CACHED
        $imagenesMap = Cache::remember('imagenes_map_global', 1800, function () {
            return \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();
        });

        // Cargar platos típicos del departamento (sabores del departamento, evitando repeticiones)
        $usedImages = [];
        $platosTipicos = collect([]);
        
        if ($nombreDepartamento) {
            $platosTipicos = \DB::table('tabla_gastronomia')
                ->where('DEPARTAMENTO', $nombreDepartamento)
                ->get()
                ->filter(function ($row) {
                    $nombre = trim($row->PLATOS_TIPICOS ?? '');
                    return !empty($nombre) && $nombre !== 'PLATOS_TIPICOS';
                })
                ->map(function ($row) use (&$usedImages, $imagenesMap) {
                    $nombre = trim($row->PLATOS_TIPICOS ?? '');
                    $departamento = trim($row->DEPARTAMENTO ?? '');
                    $categoria = trim($row->CATEGORIA ?? '');

                    $imagenData = \App\Helpers\ImageHelper::getGastronomiaImage($nombre, $departamento, $categoria, $usedImages, $imagenesMap);

                    if ($imagenData['url']) {
                        $usedImages[] = $imagenData['url'];
                    }

                    return (object)[
                        'id' => $row->ID_PLATOS,
                        'nombre' => $nombre,
                        'categoria' => $categoria,
                        'departamento' => $departamento,
                        'imagen' => $imagenData['url'],
                        'department_slug' => $this->normalizeText($departamento),
                        'slug' => $this->normalizeText($nombre),
                    ];
                })
                ->take(6)
                ->values();
        }

        $item = (object)[
            'id' => $municipio->ID,
            'nombre' => $nombreMunicipio,
            'descripcion' => $municipio->DESCRIPCION ?? 'Sin descripción',
            'localities_id' => $municipio->ID_LOCALITIES,
            'departamento_nombre' => $nombreDepartamento ?? 'Colombia',
            'region' => $nombreRegion,
            'imagen' => $imagen,
            'slug' => $municipalitySlug,
            'departamento_slug' => $departmentSlug,
            'categorias' => $categorias,
            'experiencias_locales' => $experienciasLocales,
            'platosTipicos' => $platosTipicos
        ];

        return view('pages.detalle-municipio', compact('item', 'reviews', 'averageRating', 'reviewsCount'))->with('tipo', 'Municipio');
    }

    /**
     * Mostrar municipios de un departamento específico
     */
    public function porDepartamento($departamento_id)
    {
        // NOTA: tabla_municipios no tiene ID_DEPARTAMENTO, se relaciona via tabla_localities
        // Este método necesita el nombre del departamento en lugar del ID
        // Buscar localities del departamento
        $localities = \DB::table('tabla_localities')
            ->where('DEPARTAMENTO', $departamento_id)
            ->pluck('ID')
            ->toArray();

        if (empty($localities)) {
            return view('pages.municipios', [
                'items' => collect([]),
                'error' => 'No se encontraron municipios para el departamento: ' . $departamento_id
            ]);
        }

        $municipios = \DB::table('tabla_municipios')
            ->whereIn('ID_LOCALITIES', $localities)
            ->orderBy('NOMBRE_MUNICIPIOS')
            ->get();

        // Combinar con datos del municipio
        $municipios_con_localidad = $municipios->map(function($municipio) {
            $municipio_con_localidad = (object)[
                'id' => $municipio->ID,
                'nombre' => $municipio->NOMBRE_MUNICIPIOS,
                'descripcion' => $municipio->DESCRIPCION
            ];

            return $municipio_con_localidad;
        });

        return view('pages.municipios', [
            'items' => $municipios_con_localidad,
            'departamento' => $departamento_id
        ]);
    }
}
