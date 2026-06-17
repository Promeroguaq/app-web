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
            
            // Cargar municipios primero sin join para evitar duplicados
            $query = \DB::table('tabla_municipios')
                ->select(
                    'tabla_municipios.ID_MUNICIPIOS as id',
                    'tabla_municipios.NOMBRE_MUNICIPIOS as nombre',
                    'tabla_municipios.DESCRIPCION as descripcion',
                    'tabla_municipios.ID_DEPARTAMENTO as departamento_id'
                );
            
            // Aplicar filtro de búsqueda normalizada
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                $normalizedSearch = $this->normalizeText($searchTerm);
                
                $query->where(function($q) use ($searchTerm, $normalizedSearch) {
                    // Búsqueda por nombre (con y sin normalizar)
                    $q->where('tabla_municipios.NOMBRE_MUNICIPIOS', 'like', '%' . $searchTerm . '%')
                      ->orWhere('tabla_municipios.DESCRIPCION', 'like', '%' . $searchTerm . '%');
                    
                    // Búsqueda normalizada (para tildes y mayúsculas)
                    if ($normalizedSearch) {
                        $q->orWhereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(tabla_municipios.NOMBRE_MUNICIPIOS), 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u') LIKE ?", ['%' . $normalizedSearch . '%']);
                    }
                });
            }
            
            // Filtro por departamento
            if ($request->has('departamento') && !empty($request->departamento)) {
                $departamentoSlug = $request->departamento;
                $departamentos = $this->getDepartments();
                $departamento = $departamentos->firstWhere('slug', $departamentoSlug);
                
                if ($departamento) {
                    $query->where('tabla_municipios.ID_DEPARTAMENTO', $departamento['id']);
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
                ->orderBy('tabla_municipios.NOMBRE_MUNICIPIOS')
                ->offset(($page - 1) * $perPage)
                ->limit($perPage)
                ->get();
            
            // Cargar departamentos por separado para evitar duplicados por join
            $departamentoIds = $municipios->pluck('departamento_id')->filter()->unique()->toArray();
            $departamentosData = [];
            if (!empty($departamentoIds)) {
                $departamentosData = \DB::table('tabla_departamentos')
                    ->whereIn('ID_DEPARTAMENTO', $departamentoIds)
                    ->get()
                    ->keyBy('ID_DEPARTAMENTO');
            }
            
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
            
            // Combinar con datos del municipio e imágenes
            $municipios_con_localidad = $municipios->map(function($municipio) use ($departamentosData, $imagenesPorNombre) {
                // Obtener nombre del departamento
                $departamentoNombre = null;
                if (!empty($municipio->departamento_id) && isset($departamentosData[$municipio->departamento_id])) {
                    $departamentoNombre = $departamentosData[$municipio->departamento_id]->NOMBRE_DEPARTAMENTO;
                }
                
                $imagen = ImageHelper::getMunicipioImage($municipio->nombre, $departamentoNombre, $imagenesPorNombre);
                
                return (object)[
                    'id' => $municipio->id,
                    'nombre' => $municipio->nombre,
                    'descripcion' => $municipio->descripcion,
                    'departamento_id' => $municipio->departamento_id,
                    'departamento_nombre' => $departamentoNombre,
                    'imagen' => $imagen,
                    'slug' => $this->normalizeText($municipio->nombre),
                    'departamento_slug' => $this->normalizeText($departamentoNombre ?? '')
                ];
            });
            
            \Log::info("Municipios cargados", [
                'total_raw' => $municipios->count(),
                'total_mapped' => $municipios_con_localidad->count(),
                'page' => $page,
                'per_page' => $perPage,
                'total_filtered' => $total
            ]);
            
            if ($municipios_con_localidad->count() > 0) {
                \Log::info("Primer municipio ID: " . $municipios_con_localidad->first()->id . ", Nombre: " . $municipios_con_localidad->first()->nombre);
            }

            return view('pages.municipios', [
                'items' => $municipios_con_localidad,
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
        try {
            \Log::info("Intentando cargar municipio con ID: " . $id);
            
            // Primero obtener el municipio sin join para evitar timeout
            $municipio = \DB::table('tabla_municipios')
                ->where('ID_MUNICIPIOS', $id)
                ->first();
            
            if (!$municipio) {
                \Log::error("Municipio no encontrado con ID: " . $id);
                // Intentar buscar por nombre como fallback
                $municipio = \DB::table('tabla_municipios')
                    ->where('NOMBRE_MUNICIPIOS', 'like', '%' . $id . '%')
                    ->first();
                
                if (!$municipio) {
                    // Retornar vista de error en lugar de JSON 404
                    return view('pages.detalle-municipio', [
                        'item' => null,
                        'error' => 'Municipio no encontrado con ID: ' . $id,
                        'tipo' => 'Municipio'
                    ]);
                }
            }
            
            // Obtener nombre del departamento por separado
            $departamento_nombre = 'Colombia';
            try {
                $depto = \DB::table('tabla_departamentos')
                    ->where('ID_DEPARTAMENTO', $municipio->ID_DEPARTAMENTO)
                    ->first();
                if ($depto) {
                    $departamento_nombre = $depto->NOMBRE_DEPARTAMENTO;
                }
            } catch (\Exception $e) {
                // Si falla, usar valor por defecto
            }
            
            // Obtener imagen usando ImageHelper
            $imagen = ImageHelper::getMunicipioImage($municipio->NOMBRE_MUNICIPIOS, $departamento_nombre);
            
            // Generar slugs para URLs
            $departmentSlug = $this->normalizeText($departamento_nombre);
            $municipalitySlug = $this->normalizeText($municipio->NOMBRE_MUNICIPIOS);
            
            // Cargar categorías de puntos de interés desde BD
            $categorias = $this->loadMunicipalityCategories($municipio->ID_MUNICIPIOS, $municipio->NOMBRE_MUNICIPIOS, $departamento_nombre);

            // Cargar experiencias locales contextuales
            $experienciasLocales = \App\Helpers\LocalExperienceResolver::forMunicipality(
                $municipio->NOMBRE_MUNICIPIOS,
                $departamento_nombre,
                $municipio->ID_DEPARTAMENTO
            );

            $item = (object)[
                'id' => $municipio->ID_MUNICIPIOS,
                'nombre' => $municipio->NOMBRE_MUNICIPIOS,
                'descripcion' => $municipio->DESCRIPCION ?? 'Sin descripción',
                'departamento_id' => $municipio->ID_DEPARTAMENTO,
                'departamento_nombre' => $departamento_nombre,
                'imagen' => $imagen,
                'slug' => $municipalitySlug,
                'departamento_slug' => $departmentSlug,
                'categorias' => $categorias,
                'experiencias_locales' => $experienciasLocales
            ];

            return view('pages.detalle-municipio', compact('item'))->with('tipo', 'Municipio');
        } catch (\Exception $e) {
            \Log::error("Error en MunicipioController@show: " . $e->getMessage());
            // Retornar vista de error en lugar de JSON 500
            return view('pages.detalle-municipio', [
                'item' => null,
                'error' => 'Error al cargar el municipio: ' . $e->getMessage(),
                'tipo' => 'Municipio'
            ]);
        }
    }

    /**
     * Mostrar un municipio por slugs (departmentSlug/municipalitySlug)
     */
    public function showBySlugs($departmentSlug, $municipalitySlug)
    {
        try {
            \Log::info('Buscando municipio por slugs', [
                'departmentSlug' => $departmentSlug,
                'municipalitySlug' => $municipalitySlug,
            ]);

            // Buscar departamento por slug usando normalización SQL
            $departamento = \DB::table('tabla_departamentos')
                ->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(NOMBRE_DEPARTAMENTO), 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u') = ?", [$departmentSlug])
                ->first();

            if (!$departamento) {
                \Log::warning('Departamento no encontrado en showBySlugs', ['departmentSlug' => $departmentSlug]);
                abort(404);
            }

            // Buscar municipio por slug dentro del departamento usando normalización SQL
            $municipio = \DB::table('tabla_municipios')
                ->where('ID_DEPARTAMENTO', $departamento->ID_DEPARTAMENTO)
                ->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(NOMBRE_MUNICIPIOS), 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u') = ?", [$municipalitySlug])
                ->first();

            if (!$municipio) {
                \Log::warning('Municipio no encontrado en showBySlugs', [
                    'departmentSlug' => $departmentSlug,
                    'municipalitySlug' => $municipalitySlug,
                    'departamento' => $departamento->NOMBRE_DEPARTAMENTO,
                ]);
                abort(404);
            }

            // Obtener imagen usando ImageHelper
            $imagen = ImageHelper::getMunicipioImage($municipio->NOMBRE_MUNICIPIOS, $departamento->NOMBRE_DEPARTAMENTO);

            // Cargar categorías de puntos de interés desde BD
            $categorias = $this->loadMunicipalityCategories($municipio->ID_MUNICIPIOS, $municipio->NOMBRE_MUNICIPIOS, $departamento->NOMBRE_DEPARTAMENTO);

            // Cargar experiencias locales contextuales
            $experienciasLocales = \App\Helpers\LocalExperienceResolver::forMunicipality(
                $municipio->NOMBRE_MUNICIPIOS,
                $departamento->NOMBRE_DEPARTAMENTO,
                $municipio->ID_DEPARTAMENTO
            );

            // Cargar reviews del municipio
            $municipioModel = \App\Models\Municipio::find($municipio->ID_MUNICIPIOS);
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
            $platosTipicos = \DB::table('tabla_gastronomia')
                ->where('DEPARTAMENTO', $departamento->NOMBRE_DEPARTAMENTO)
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

            $item = (object)[
                'id' => $municipio->ID_MUNICIPIOS,
                'nombre' => $municipio->NOMBRE_MUNICIPIOS,
                'descripcion' => $municipio->DESCRIPCION ?? 'Sin descripción',
                'departamento_id' => $municipio->ID_DEPARTAMENTO,
                'departamento_nombre' => $departamento->NOMBRE_DEPARTAMENTO,
                'imagen' => $imagen,
                'slug' => $municipalitySlug,
                'departamento_slug' => $departmentSlug,
                'categorias' => $categorias,
                'experiencias_locales' => $experienciasLocales,
                'platosTipicos' => $platosTipicos
            ];

            return view('pages.detalle-municipio', compact('item', 'reviews', 'averageRating', 'reviewsCount'))->with('tipo', 'Municipio');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar municipios de un departamento específico
     */
    public function porDepartamento($departamento_id)
    {
        try {
            $municipios = \DB::table('tabla_municipios')
                ->where('ID_DEPARTAMENTO', $departamento_id)
                ->orderBy('NOMBRE_MUNICIPIOS')
                ->get();
            
            // Combinar con datos del municipio
            $municipios_con_localidad = $municipios->map(function($municipio) {
                $municipio_con_localidad = (object)[
                    'id' => $municipio->ID_MUNICIPIOS,
                    'nombre' => $municipio->NOMBRE_MUNICIPIOS,
                    'descripcion' => $municipio->DESCRIPCION
                ];
                
                return $municipio_con_localidad;
            });

            return view('pages.municipios', [
                'items' => $municipios_con_localidad,
                'departamento_id' => $departamento_id
            ]);
        } catch (\Exception $e) {
            return view('pages.municipios', [
                'items' => collect([]),
                'error' => 'La tabla de municipios no está disponible en este momento.'
            ]);
        }
    }
}
