<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DepartamentoController extends Controller
{
    /**
     * Mostrar todos los departamentos
     */
    public function index()
    {
        try {
            // Obtener datos de la tabla tabla_departamentos con región desde tabla_localities
            $departamentos = \DB::table('tabla_departamentos as d')
                ->leftJoin('tabla_localities as l', function($join) {
                    $join->on('d.NOMBRE_DEPARTAMENTO', '=', 'l.DEPARTAMENTO');
                })
                ->select(
                    'd.ID_DEPARTAMENTO',
                    'd.NOMBRE_DEPARTAMENTO',
                    'd.DESCRIPCION',
                    \DB::raw('MAX(l.REGION) as region')
                )
                ->groupBy('d.ID_DEPARTAMENTO', 'd.NOMBRE_DEPARTAMENTO', 'd.DESCRIPCION')
                ->orderBy('d.NOMBRE_DEPARTAMENTO')
                ->get();
            
            // Log para debug: contar departamentos raw
            \Log::info('Departamentos raw count', ['count' => $departamentos->count()]);
            
            // Cargar imágenes una sola vez en memoria para evitar consultas repetidas
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')->get();
            });
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });
            
            // Lista para rastrear imágenes ya usadas y evitar repeticiones
            $imagenesUsadas = [];
            
            // Combinar departamentos con sus imágenes usando búsqueda en memoria
            $departamentos_con_imagenes = $departamentos->map(function($depto) use ($imagenesPorNombre, &$imagenesUsadas) {
                $nombreNormalizado = ImageHelper::cleanString($depto->NOMBRE_DEPARTAMENTO);
                
                // Buscar imagen por nombre exacto en memoria
                $imagen = null;
                if (isset($imagenesPorNombre[$nombreNormalizado])) {
                    $ruta = $imagenesPorNombre[$nombreNormalizado]->RUTA;
                    if (!in_array($ruta, $imagenesUsadas)) {
                        $imagen = $ruta;
                        $imagenesUsadas[] = $ruta;
                    }
                }
                
                // Log para debug: imagen y región resueltas
                \Log::info('Departamento resuelto', [
                    'departamento' => $depto->NOMBRE_DEPARTAMENTO,
                    'region' => $depto->region,
                    'image_url' => $imagen
                ]);
                
                // Generar slug para URLs - IMPORTANTE: trim() para eliminar espacios
                $slug = $this->normalizeText(trim($depto->NOMBRE_DEPARTAMENTO));

                return (object)[
                    'id' => $depto->ID_DEPARTAMENTO,
                    'nombre' => $depto->NOMBRE_DEPARTAMENTO,
                    'descripcion' => $depto->DESCRIPCION ?? null,
                    'imagen' => $imagen,
                    'slug' => $slug,
                    'region' => $depto->region
                ];
            });

            return view('pages.departamentos', ['items' => $departamentos_con_imagenes]);
        } catch (\Exception $e) {
            \Log::error('Error loading departamentos: ' . $e->getMessage());
            return view('pages.departamentos', [
                'items' => collect([]),
                'error' => 'La tabla de departamentos no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar un departamento específico (con soporte temporal para ID)
     */
    public function show($id)
    {
        try {
            $departamento = \DB::table('tabla_departamentos')->where('ID_DEPARTAMENTO', $id)->first();

            if (!$departamento) {
                abort(404);
            }

            // Generar slug para URLs
            $slug = $this->normalizeText($departamento->NOMBRE_DEPARTAMENTO);

            // Redirección temporal: si se usa ID numérico, redirigir al slug
            if (is_numeric($id)) {
                return redirect()->route('departamentos.show.slug', $slug);
            }

            // Obtener imagen usando ImageHelper
            $imagen = ImageHelper::getDepartamentoImage($departamento->NOMBRE_DEPARTAMENTO);

            // Cargar categorías de puntos de interés desde BD
            $categorias = $this->loadDepartmentCategories($departamento->ID_DEPARTAMENTO, $departamento->NOMBRE_DEPARTAMENTO);

            $item = (object)[
                'id' => $departamento->ID_DEPARTAMENTO,
                'nombre' => $departamento->NOMBRE_DEPARTAMENTO,
                'descripcion' => $departamento->DESCRIPCION,
                'imagen' => $imagen,
                'slug' => $slug,
                'categorias' => $categorias
            ];

            return view('pages.detalle-departamento', compact('item'))->with('tipo', 'Departamento');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar un departamento por slug
     */
    public function showBySlug($slug)
    {
        try {
            \Log::info('Buscando departamento por slug', [
                'slug' => $slug,
            ]);

            // Buscar departamento por slug usando LIKE con normalización SQL
            // IMPORTANTE: trim() para eliminar espacios en la comparación
            $departamento = \DB::table('tabla_departamentos')
                ->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(TRIM(NOMBRE_DEPARTAMENTO)), 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u') = ?", [$slug])
                ->first();

            if (!$departamento) {
                \Log::warning('Departamento no encontrado por slug', ['slug' => $slug]);
                abort(404);
            }

            // Obtener imagen usando ImageHelper
            $imagen = ImageHelper::getDepartamentoImage($departamento->NOMBRE_DEPARTAMENTO);

            // Cargar categorías de puntos de interés desde BD
            $categorias = $this->loadDepartmentCategories($departamento->ID_DEPARTAMENTO, $departamento->NOMBRE_DEPARTAMENTO);

            // Cargar todos los municipios del departamento con imágenes
            $allMunicipios = \DB::table('tabla_municipios')
                ->where('ID_DEPARTAMENTO', $departamento->ID_DEPARTAMENTO)
                ->orderBy('NOMBRE_MUNICIPIOS')
                ->get();

            // Cargar imágenes en memoria para municipios
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')->get();
            });
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });

            $departamentoNombre = $departamento->NOMBRE_DEPARTAMENTO;

            // Resolver imagen para cada municipio
            $allMunicipiosConImagen = $allMunicipios->map(function($municipio) use ($imagenesPorNombre, $departamentoNombre) {
                $nombreNormalizado = ImageHelper::cleanString($municipio->NOMBRE_MUNICIPIOS);
                $imagenUrl = null;
                
                if (isset($imagenesPorNombre[$nombreNormalizado])) {
                    $imagenUrl = $imagenesPorNombre[$nombreNormalizado]->RUTA;
                }
                
                // Log para debug
                \Log::info('Imagen municipio en detalle departamento', [
                    'municipio' => $municipio->NOMBRE_MUNICIPIOS,
                    'image_url' => $imagenUrl
                ]);
                
                return (object)[
                    'ID_MUNICIPIOS' => $municipio->ID_MUNICIPIOS,
                    'NOMBRE_MUNICIPIOS' => $municipio->NOMBRE_MUNICIPIOS,
                    'DESCRIPCION' => $municipio->DESCRIPCION,
                    'imagen' => $imagenUrl,
                    'slug' => $this->normalizeText($municipio->NOMBRE_MUNICIPIOS)
                ];
            });

            // Municipios destacados (primeros 6)
            $municipiosConImagen = $allMunicipiosConImagen->take(6);

            // Cargar mapa de imágenes una sola vez para platos típicos
            $imagenesMap = \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();

            // Cargar platos típicos del departamento (evitando repeticiones)
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
                ->take(8)
                ->values();

            \Log::info('Platos típicos cargados para departamento', [
                'departamento' => $departamento->NOMBRE_DEPARTAMENTO,
                'count' => $platosTipicos->count(),
            ]);

            $item = (object)[
                'id' => $departamento->ID_DEPARTAMENTO,
                'nombre' => $departamento->NOMBRE_DEPARTAMENTO,
                'descripcion' => $departamento->DESCRIPCION,
                'imagen' => $imagen,
                'slug' => $slug,
                'categorias' => $categorias,
                'municipios' => $municipiosConImagen,
                'allMunicipios' => $allMunicipiosConImagen,
                'platosTipicos' => $platosTipicos
            ];

            return view('pages.detalle-departamento', compact('item'))->with('tipo', 'Departamento');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Normalize text for slug
     */
    private function normalizeText($text)
    {
        // Use Laravel's Str::slug for proper slug generation
        return \Illuminate\Support\Str::slug($text);
    }

    /**
     * Cargar categorías de puntos de interés para un departamento desde BD
     */
    private function loadDepartmentCategories($departamentoId, $departamentoNombre)
    {
        $categorias = [];

        // Tablas de categorías disponibles en BD (con prefijo tabla_)
        $categoryTables = [
            'tabla_playas' => 'Playas',
            'tabla_museos' => 'Museos',
            'tabla_iglesias' => 'Iglesias',
            'tabla_parque_tematicos' => 'Parques Temáticos',
            'tabla_termales' => 'Termales',
            'tabla_deportes_aventura' => 'Deportes de Aventura',
            'tabla_ciclismo' => 'Ciclismo',
            'tabla_desierto_laguna' => 'Desiertos y Lagunas',
            'tabla_islas' => 'Islas',
        ];

        foreach ($categoryTables as $table => $displayName) {
            try {
                // Intentar cargar datos de la tabla filtrando por departamento
                // Usar columnas reales de cada tabla
                $items = \DB::table($table)
                    ->where('DEPARTAMENTO', $departamentoNombre)
                    ->limit(10)
                    ->get();

                if ($items->count() > 0) {
                    $categorias[$table] = $items->map(function($item) use ($table, $departamentoNombre, $displayName) {
                        // Mapear columnas según la tabla
                        $id = null;
                        $nombre = null;
                        $descripcion = null;

                        // Columnas por tabla
                        if ($table === 'tabla_playas') {
                            $id = $item->ID_PLAYA ?? $item->{'COL 1'} ?? null;
                            $nombre = $item->NOMBRE_PLAYA ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_museos') {
                            $id = $item->ID_MUSEO ?? $item->{'COL 1'} ?? null;
                            $nombre = $item->NOMBRE_MUSEO ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_iglesias') {
                            $id = $item->ID_IGLESIA ?? null;
                            $nombre = $item->NOMBRE_IGLESIA ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_parque_tematicos') {
                            $id = $item->ID_PARQUE ?? $item->{'COL 1'} ?? null;
                            $nombre = $item->NOMBRE ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_termales') {
                            $id = $item->ID_TERMALES ?? null;
                            $nombre = $item->NOMBRE_TERMAL ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_deportes_aventura') {
                            $id = $item->ID_DEPORTE ?? $item->{'COL 1'} ?? null;
                            $nombre = $item->NOMBRE_DEPORTE ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_ciclismo') {
                            $id = $item->ID_CICLISMO ?? null;
                            $nombre = $item->NOMBRE_RUTA_CICLISMO ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_desierto_laguna') {
                            $id = $item->ID_DESIERTO ?? null;
                            $nombre = $item->NOMBRE_DESIERTO_LAGUNAS ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        } elseif ($table === 'tabla_islas') {
                            $id = $item->ID_ISLA ?? null;
                            $nombre = $item->NOMBRE_ISLA ?? null;
                            $descripcion = $item->DESCRIPCION ?? null;
                        }

                        return (object)[
                            'id' => $id,
                            'nombre' => $nombre ?? 'Sin nombre',
                            'descripcion' => $descripcion ?? 'Descubre este lugar increíble en ' . $departamentoNombre,
                            'categoria' => $displayName,
                            'imagen' => null,
                            'slug' => $this->normalizeText($nombre ?? ''),
                        ];
                    })->toArray();
                }
            } catch (\Exception $e) {
                // Si la tabla no existe o hay error, continuar con la siguiente
                \Log::warning("Error cargando categoría {$table} para departamento: " . $e->getMessage());
            }
        }

        // Si no hay datos específicos del departamento, usar fallback contextual
        if (empty($categorias)) {
            $categorias = $this->loadDepartmentCategoriesFallback($departamentoNombre);
        }

        return $categorias;
    }

    /**
     * Fallback: cargar categorías contextuales cuando el departamento no tiene datos en BD
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
                    (object)['nombre' => 'Playas del Caribe', 'descripcion' => 'Playas paradisíacas del Atlántico', 'categoria' => 'Playas', 'imagen' => null, 'slug' => 'playas-caribe'],
                ],
            ],
            'antioquia' => [
                'gastronomia' => [
                    (object)['nombre' => 'Bandeja Paisa', 'descripcion' => 'Plato típico antioqueño', 'categoria' => 'Gastronomía', 'imagen' => null, 'slug' => 'bandeja-paisa'],
                    (object)['nombre' => 'Arepas Antioqueñas', 'descripcion' => 'Arepas con queso', 'categoria' => 'Gastronomía', 'imagen' => null, 'slug' => 'arepas-antioquenas'],
                ],
                'cultura' => [
                    (object)['nombre' => 'Pueblos Paisas', 'descripcion' => 'Pueblos tradicionales de Antioquia', 'categoria' => 'Cultura', 'imagen' => null, 'slug' => 'pueblos-paisas'],
                ],
            ],
            'amazonas' => [
                'naturaleza' => [
                    (object)['nombre' => 'Selva Amazónica', 'descripcion' => 'Biodiversidad única en el mundo', 'categoria' => 'Naturaleza', 'imagen' => null, 'slug' => 'selva-amazonica'],
                    (object)['nombre' => 'Río Amazonas', 'descripcion' => 'El río más caudaloso del mundo', 'categoria' => 'Naturaleza', 'imagen' => null, 'slug' => 'rio-amazonas'],
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
     * Mostrar formulario para crear un nuevo departamento
     */
    public function create()
    {
        return view('pages.departamentos.create');
    }

    /**
     * Guardar un nuevo departamento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'required'
        ]);

        Departamento::create([
            'NOMBRE_DEPARTAMENTO' => $validated['nombre'],
            'DESCRIPCION' => $validated['descripcion']
        ]);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar un departamento
     */
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);

        return view('pages.departamentos.edit', compact('departamento'));
    }

    /**
     * Actualizar un departamento
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'required'
        ]);

        $departamento = Departamento::findOrFail($id);

        $departamento->update([
            'NOMBRE_DEPARTAMENTO' => $validated['nombre'],
            'DESCRIPCION' => $validated['descripcion']
        ]);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Eliminar un departamento
     */
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento eliminado exitosamente.');
    }

    /**
     * Buscar departamentos por nombre
     */
    public function buscar(Request $request)
    {
        $query = $request->get('q');

        $departamentos = Departamento::where('NOMBRE_DEPARTAMENTO', 'LIKE', "%{$query}%")
            ->orderBy('NOMBRE_DEPARTAMENTO')
            ->get();

        return view('pages.departamentos.index', compact('departamentos'));
    }
}