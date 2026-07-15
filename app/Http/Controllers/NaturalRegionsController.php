<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Cache;

class NaturalRegionsController extends Controller
{
    /**
     * Mostrar lista de regiones naturales
     */
    public function index()
    {
        try {
            set_time_limit(120);
            
            // Mapeo entre tabla_regiones.NOMBRE_REGION y tabla_localities.REGION
            $regionMapping = [
                'CARIBE' => 'Costa Caribe',
                'LLANOS' => 'Llanos Orientales',
                'ANTIOQUIA Y EJE CAFETERO' => 'Antioquia y Eje Cafetero',
                'PACÍFICO' => 'Costa Pacífica',
                'CENTRO' => 'Centro',
                'AMAZONÍA' => 'Amazonia'
            ];
            
            // Mapeo de slugs y colores para UI
            $regionUIMapping = [
                'Costa Caribe' => [
                    'slug' => 'caribe',
                    'color' => '#f59e0b',
                    'accent' => 'amber',
                    'searchTerms' => ['caribe', 'playa', 'mar', 'cartagena', 'santa marta', 'barranquilla']
                ],
                'Llanos Orientales' => [
                    'slug' => 'llanos',
                    'color' => '#84cc16',
                    'accent' => 'lime',
                    'searchTerms' => ['llanos', 'sabana', 'villavicencio', 'yopal', 'joropo']
                ],
                'Antioquia y Eje Cafetero' => [
                    'slug' => 'andina',
                    'color' => '#8b5cf6',
                    'accent' => 'violet',
                    'searchTerms' => ['andina', 'montaña', 'café', 'medellin', 'bogota', 'eje cafetero']
                ],
                'Costa Pacífica' => [
                    'slug' => 'pacifica',
                    'color' => '#0ea5e9',
                    'accent' => 'cyan',
                    'searchTerms' => ['pacifico', 'ballena', 'selva', 'buenaventura', 'nuqui']
                ],
                'Centro' => [
                    'slug' => 'centro',
                    'color' => '#6366f1',
                    'accent' => 'indigo',
                    'searchTerms' => ['centro', 'bogota', 'cundinamarca', 'boyaca']
                ],
                'Amazonia' => [
                    'slug' => 'amazonia',
                    'color' => '#059669',
                    'accent' => 'emerald',
                    'searchTerms' => ['amazonia', 'selva', 'rio', 'leticia', 'florecia']
                ]
            ];
            
            // Cargar regiones desde tabla_regiones
            $tablaRegiones = \DB::table('tabla_regiones')
                ->orderBy('ID_REGION')
                ->get();
            
            // Cargar imágenes disponibles en memoria
            $imagenes = \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });
            
            $usedImageIds = [];
            $regions = collect();
            
            foreach ($tablaRegiones as $regionRow) {
                // Obtener el nombre de región en tabla_localities usando el mapeo
                $localityRegionName = $regionMapping[$regionRow->NOMBRE_REGION] ?? null;
                
                if (!$localityRegionName) {
                    \Log::warning('Región sin mapeo a tabla_localities', ['region' => $regionRow->NOMBRE_REGION]);
                    continue;
                }
                
                // Obtener departamentos de esta región desde tabla_localities
                $departments = \DB::table('tabla_localities')
                    ->where('REGION', $localityRegionName)
                    ->whereNotNull('DEPARTAMENTO')
                    ->where('DEPARTAMENTO', '!=', '')
                    ->distinct()
                    ->orderBy('DEPARTAMENTO')
                    ->pluck('DEPARTAMENTO');
                
                // Obtener municipios
                $municipiosCount = \DB::table('tabla_localities')
                    ->where('REGION', $localityRegionName)
                    ->whereNotNull('MUNICIPIOS')
                    ->where('MUNICIPIOS', '!=', '')
                    ->distinct()
                    ->count('MUNICIPIOS');
                
                // Obtener configuración UI
                $uiConfig = $regionUIMapping[$localityRegionName] ?? [
                    'slug' => strtolower(str_replace(' ', '-', $localityRegionName)),
                    'color' => '#6366f1',
                    'accent' => 'indigo',
                    'searchTerms' => []
                ];
                
                // Convertir departamentos a objetos con slug
                $regionDepartments = collect();
                foreach ($departments as $deptName) {
                    $slug = strtolower(str_replace(' ', '-', $deptName));
                    $regionDepartments->push((object)[
                        'name' => $deptName,
                        'slug' => $slug
                    ]);
                }
                
                // Seleccionar imagen determinista
                $imageUrl = null;
                foreach ($uiConfig['searchTerms'] as $term) {
                    $termNormalized = ImageHelper::cleanString($term);
                    if (isset($imagenesPorNombre[$termNormalized])) {
                        $img = $imagenesPorNombre[$termNormalized];
                        if (!in_array($img->ID_IMAGEN, $usedImageIds)) {
                            $imageUrl = $img->RUTA;
                            $usedImageIds[] = $img->ID_IMAGEN;
                            break;
                        }
                    }
                }
                
                // Si no hay imagen por términos, buscar por departamentos
                if (!$imageUrl) {
                    foreach ($regionDepartments as $dept) {
                        $deptNormalized = ImageHelper::cleanString($dept->name);
                        if (isset($imagenesPorNombre[$deptNormalized])) {
                            $img = $imagenesPorNombre[$deptNormalized];
                            if (!in_array($img->ID_IMAGEN, $usedImageIds)) {
                                $imageUrl = $img->RUTA;
                                $usedImageIds[] = $img->ID_IMAGEN;
                                break;
                            }
                        }
                    }
                }
                
                // Calcular departamentos visibles
                $visibleDepartments = $regionDepartments->take(3);
                $remainingCount = max(0, $regionDepartments->count() - $visibleDepartments->count());
                
                // Nombre amigable para UI
                $displayName = $localityRegionName;
                
                $regions->push((object)[
                    'id' => $regionRow->ID_REGION,
                    'slug' => $uiConfig['slug'],
                    'name' => 'Región ' . $displayName,
                    'shortName' => $displayName,
                    'description' => $regionRow->DESCRIPCION ?? 'Información turística en actualización.',
                    'color' => $uiConfig['color'],
                    'accent' => $uiConfig['accent'],
                    'image_url' => $imageUrl,
                    'departments' => $regionDepartments,
                    'departments_count' => $departments->count(),
                    'visible_departments' => $visibleDepartments,
                    'remaining_departments' => $remainingCount,
                    'municipios_count' => $municipiosCount
                ]);
            }
            
            return view('pages.regiones', compact('regions'));
        } catch (\Exception $e) {
            \Log::error('Error loading regiones: ' . $e->getMessage());
            return view('pages.regiones', [
                'regions' => collect([]),
                'error' => 'Error al cargar regiones naturales: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Mostrar detalle de una región natural
     */
    public function show($slug)
    {
        try {
            set_time_limit(120);
            
            // Mapeo inverso: slug -> nombre de región en tabla_localities
            $slugToLocalityRegion = [
                'caribe' => 'Costa Caribe',
                'llanos' => 'Llanos Orientales',
                'andina' => 'Antioquia y Eje Cafetero',
                'pacifica' => 'Costa Pacífica',
                'centro' => 'Centro',
                'amazonia' => 'Amazonia'
            ];
            
            // Mapeo inverso: locality region -> tabla_regiones nombre
            $localityToTablaRegion = [
                'Costa Caribe' => 'CARIBE',
                'Llanos Orientales' => 'LLANOS',
                'Antioquia y Eje Cafetero' => 'ANTIOQUIA Y EJE CAFETERO',
                'Costa Pacífica' => 'PACÍFICO',
                'Centro' => 'CENTRO',
                'Amazonia' => 'AMAZONÍA'
            ];
            
            // Obtener nombre de región en tabla_localities desde el slug
            $localityRegionName = $slugToLocalityRegion[$slug] ?? null;
            
            if (!$localityRegionName) {
                abort(404);
            }
            
            // Obtener nombre de región en tabla_regiones
            $tablaRegionName = $localityToTablaRegion[$localityRegionName] ?? null;
            
            // Cargar datos de la región desde tabla_regiones
            $regionData = \DB::table('tabla_regiones')
                ->where('NOMBRE_REGION', $tablaRegionName)
                ->first();
            
            if (!$regionData) {
                abort(404);
            }
            
            // Cargar departamentos de esta región desde tabla_localities con conteo de municipios
            $departments = \DB::table('tabla_localities')
                ->select(
                    'DEPARTAMENTO',
                    'REGION',
                    \DB::raw('COUNT(DISTINCT MUNICIPIOS) as total_municipios')
                )
                ->where('REGION', $localityRegionName)
                ->whereNotNull('DEPARTAMENTO')
                ->where('DEPARTAMENTO', '!=', '')
                ->groupBy('DEPARTAMENTO', 'REGION')
                ->orderBy('DEPARTAMENTO')
                ->get();
            
            // Cargar imágenes en memoria
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')->get();
            });
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });
            
            // Cargar descripciones de departamentos desde tabla_departamentos
            $deptDescriptions = \DB::table('tabla_departamentos')
                ->pluck('DESCRIPCION', 'NOMBRE_DEPARTAMENTO');
            
            // Resolver imágenes y datos completos para departamentos
            $departmentsWithImages = collect();
            foreach ($departments as $deptRow) {
                $deptName = $deptRow->DEPARTAMENTO;
                $nombreNormalizado = ImageHelper::cleanString($deptName);
                $imagenUrl = null;
                
                if (isset($imagenesPorNombre[$nombreNormalizado])) {
                    $imagenUrl = $imagenesPorNombre[$nombreNormalizado]->RUTA;
                }
                
                $slug = $this->normalizeText($deptName);
                $descripcion = $deptDescriptions[$deptName] ?? 'Información turística en actualización.';
                
                $departmentsWithImages->push((object)[
                    'name' => $deptName,
                    'slug' => $slug,
                    'image_url' => $imagenUrl,
                    'type' => 'department',
                    'region' => $localityRegionName,
                    'total_municipios' => $deptRow->total_municipios,
                    'description' => $descripcion,
                    'capital' => $deptName // Fallback, se puede mejorar con datos reales
                ]);
            }
            
            // Buscar imagen para la región
            $searchTerms = [];
            switch ($slug) {
                case 'caribe':
                    $searchTerms = ['caribe', 'playa', 'mar', 'cartagena', 'santa marta', 'barranquilla'];
                    break;
                case 'llanos':
                    $searchTerms = ['llanos', 'sabana', 'villavicencio', 'yopal', 'joropo'];
                    break;
                case 'andina':
                    $searchTerms = ['andina', 'montaña', 'café', 'medellin', 'bogota', 'eje cafetero'];
                    break;
                case 'pacifica':
                    $searchTerms = ['pacifico', 'ballena', 'selva', 'buenaventura', 'nuqui'];
                    break;
                case 'centro':
                    $searchTerms = ['centro', 'bogota', 'cundinamarca', 'boyaca'];
                    break;
                case 'amazonia':
                    $searchTerms = ['amazonia', 'selva', 'rio', 'leticia', 'florecia'];
                    break;
            }
            
            $regionImageUrl = null;
            foreach ($searchTerms as $term) {
                $termNormalized = ImageHelper::cleanString($term);
                if (isset($imagenesPorNombre[$termNormalized])) {
                    $regionImageUrl = $imagenesPorNombre[$termNormalized]->RUTA;
                    break;
                }
            }
            
            // Si no hay imagen por términos, buscar por departamentos
            if (!$regionImageUrl) {
                foreach ($departmentsWithImages as $dept) {
                    if ($dept->image_url) {
                        $regionImageUrl = $dept->image_url;
                        break;
                    }
                }
            }
            
            // Build region object
            $region = (object)[
                'id' => $regionData->ID_REGION,
                'slug' => $slug,
                'name' => 'Región ' . $localityRegionName,
                'shortName' => $localityRegionName,
                'subtitle' => $regionData->DESCRIPCION ?? 'Información turística en actualización.',
                'description' => $regionData->DESCRIPCION ?? 'Información turística en actualización.',
                'image_url' => $regionImageUrl,
                'departments' => $departmentsWithImages,
                'departmentCount' => $departments->count()
            ];
            
            return view('pages.region-detalle', compact('region'));
        } catch (\Exception $e) {
            \Log::error('Error loading region detail: ' . $e->getMessage());
            abort(404);
        }
    }
    
    /**
     * Normalize text for slug
     */
    private function normalizeText($text)
    {
        return \Illuminate\Support\Str::slug($text);
    }
}
