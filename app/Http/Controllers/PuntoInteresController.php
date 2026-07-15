<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\ImageResolver;

class PuntoInteresController extends Controller
{
    /**
     * Buscar imagen para un elemento basado en su nombre desde tabla_imagenes
     * Este método es un fallback para datos que no tienen relaciones polimórficas configuradas
     */
    private function buscarImagen($nombre, $tipo = '')
    {
        try {
            if (empty($nombre)) {
                return null;
            }

            return ImageResolver::forName($nombre, $tipo ?: null);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Mostrar deportes de aventura
     */
    public function deportesAventura()
    {
        try {
            set_time_limit(120);

            // Paginar deportes (12 por página)
            $perPage = 12;
            $page = request('page', 1);
            $offset = ($page - 1) * $perPage;

            $total = \DB::table('tabla_deporte_aventura')->count();
            $deportes = \DB::table('tabla_deporte_aventura')
                ->offset($offset)
                ->limit($perPage)
                ->get();

            // Cargar mapa de imágenes una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });

            // Cargar mapa de municipios una sola vez
            $municipiosMap = collect();
            if (\Schema::hasTable('tabla_municipios')) {
                $municipiosMap = \DB::table('tabla_municipios')
                    ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS')
                    ->get()
                    ->keyBy('ID_MUNICIPIOS');
            }

            // Calcular destinos únicos (municipios)
            $destinosCount = $deportes->pluck('ID_LOCALITIES')->unique()->filter()->count();

            // Mapear deportes con imágenes y municipios (evitando N+1 queries)
            $usedImages = [];
            $items = $deportes->map(function($deporte) use (&$usedImages, $imagenesMap, $municipiosMap) {
                // Obtener nombre de municipio desde mapa
                $localidad = null;
                if (!empty($deporte->ID_LOCALITIES) && isset($municipiosMap[$deporte->ID_LOCALITIES])) {
                    $localidad = $municipiosMap[$deporte->ID_LOCALITIES]->NOMBRE_MUNICIPIOS;
                }

                // Buscar imagen usando ImageHelper (evitando repeticiones)
                $nombre = trim($deporte->NOMBRE_DEPORTES_AVENTURA ?? '');
                $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);

                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }

                // Generar slug si no existe
                $slug = $deporte->slug ?? \Illuminate\Support\Str::slug($nombre ?: 'deporte');

                return (object)[
                    'id' => $deporte->ID_DEPORTES,
                    'nombre' => $nombre ?: 'Deporte de aventura',
                    'descripcion' => $deporte->DESCRIPCION ?? '',
                    'localidad' => $localidad,
                    'imagen' => $imagenData['url'],
                    'slug' => $slug
                ];
            })->filter(fn ($item) => !empty($item->nombre))->values();

            \Log::info('Deportes aventura index cargado', [
                'total' => $total,
                'items_count' => $items->count(),
                'destinos' => $destinosCount
            ]);

            return view('pages.deportes-aventura', compact('items', 'total', 'perPage', 'page', 'destinosCount'));
        } catch (\Exception $e) {
            \Log::error('Error en deportesAventura: ' . $e->getMessage());
            return view('pages.deportes-aventura', [
                'items' => collect([]),
                'total' => 0,
                'perPage' => 12,
                'page' => 1,
                'destinosCount' => 0,
                'error' => 'La tabla de deportes de aventura no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar desiertos y lagunas
     */
    public function desiertosLagunas()
    {
        try {
            // Obtener datos de la tabla tabla_desierto_laguna con leftJoin a localidades
            $desiertos = \DB::table('tabla_desierto_laguna as d')
                ->leftJoin('tabla_localities as l', 'd.ID_LOCALITIES', '=', 'l.ID')
                ->select('d.*', 'l.MUNICIPIOS as localidad_nombre', 'l.DEPARTAMENTO as localidad_departamento')
                ->get();
            
            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            // Array para rastrear imágenes usadas (evitar repeticiones)
            $usedImages = [];
            
            // Combinar con imágenes usando datos pre-cargados
            $items = $desiertos->map(function($desierto) use (&$usedImages, $imagenesMap) {
                // Obtener nombre de localidad desde el leftJoin
                $localidad = $desierto->localidad_nombre ?? null;
                $departamento = $desierto->localidad_departamento ?? null;
                
                // Buscar imagen usando ImageHelper con deduplicación
                $nombre = trim($desierto->NOMBRE_DESIERTO_LAGUNAS ?? '');
                $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);
                
                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }
                
                $desierto_con_imagen = (object)[
                    'id' => $desierto->ID_DESIERTO,
                    'nombre' => $nombre ?: 'Desierto o laguna',
                    'descripcion' => $desierto->DESCRIPCION ?? '',
                    'localidad' => $localidad,
                    'imagen' => $imagenData['url']
                ];
                
                return $desierto_con_imagen;
            });
            
            return view('pages.desiertos-lagunas', compact('items'));
        } catch (\Exception $e) {
            return view('pages.desiertos-lagunas', [
                'items' => collect([]),
                'error' => 'La tabla de desiertos y lagunas no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar iglesias
     */
    public function iglesias()
    {
        try {
            // Obtener datos de la tabla tabla_iglesias con leftJoin a localidades
            $iglesias = \DB::table('tabla_iglesias as i')
                ->leftJoin('tabla_localities as l', 'i.ID_LOCALITIES', '=', 'l.ID')
                ->select('i.*', 'l.MUNICIPIOS as localidad_nombre', 'l.DEPARTAMENTO as localidad_departamento')
                ->get();
            
            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            // Array para rastrear imágenes usadas (evitar repeticiones)
            $usedImages = [];
            
            // Combinar con imágenes usando datos pre-cargados
            $items = $iglesias->map(function($iglesia) use (&$usedImages, $imagenesMap) {
                // Obtener nombre de localidad desde el leftJoin
                $localidad = $iglesia->localidad_nombre ?? null;
                $departamento = $iglesia->localidad_departamento ?? null;
                
                // Buscar imagen usando ImageHelper con deduplicación
                $nombre = trim($iglesia->NOMBRE_IGLESIA ?? '');
                $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);
                
                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }
                
                $iglesia_con_imagen = (object)[
                    'id' => $iglesia->ID_IGLESIA,
                    'nombre' => $nombre ?: 'Iglesia',
                    'descripcion' => $iglesia->DESCRIPCION ?? '',
                    'localidad' => $localidad,
                    'imagen' => $imagenData['url']
                ];
                
                return $iglesia_con_imagen;
            });
            
            return view('pages.iglesias', compact('items'));
        } catch (\Exception $e) {
            return view('pages.iglesias', [
                'items' => collect([]),
                'error' => 'Error al cargar iglesias: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar islas
     */
    public function islas()
    {
        try {
            // Obtener datos de la tabla tabla_islas
            $islas = \DB::table('tabla_islas')->get();

            // Obtener imágenes de islas - CACHED
            $imagenes_islas = \Cache::remember('imagenes_islas', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->where('NOMBRE_IMAGEN', 'like', '%isla%')
                    ->orWhere('RUTA', 'like', '%/islas/%')
                    ->get();
            });

            // Combinar islas con sus imágenes
            $items = $islas->map(function($isla) use ($imagenes_islas) {
                $isla_con_imagen = (object)[
                    'id' => $isla->ID_ISLA,
                    'nombre' => $isla->NOMBRE_ISLA,
                    'descripcion' => $isla->DESCRIPCION,
                    'imagen' => null
                ];

                // Buscar imagen relacionada
                foreach($imagenes_islas as $imagen) {
                    // Buscar por nombre相似
                    if (stripos($imagen->NOMBRE_IMAGEN, $isla->NOMBRE_ISLA) !== false) {
                        $isla_con_imagen->imagen = $imagen->RUTA;
                        break;
                    }
                    // Buscar por ruta相似
                    elseif (stripos($imagen->RUTA, strtolower(str_replace(' ', '_', $isla->NOMBRE_ISLA))) !== false) {
                        $isla_con_imagen->imagen = $imagen->RUTA;
                        break;
                    }
                }

                return $isla_con_imagen;
            });

            return view('pages.islas', compact('items'));
        } catch (\Exception $e) {
            return view('pages.islas', [
                'items' => collect([]),
                'error' => 'La tabla de islas no está disponible en este momento.'
            ]);
        }
    }

    public function islasShow($id)
    {
        try {
            $isla = \DB::table('tabla_islas')->where('ID_ISLA', $id)->first();

            if (!$isla) {
                abort(404);
            }

            $item = (object)[
                'id' => $isla->ID_ISLA,
                'nombre' => $isla->NOMBRE_ISLA,
                'descripcion' => $isla->DESCRIPCION,
                'imagen' => $this->buscarImagen($isla->NOMBRE_ISLA, 'isla')
            ];

            return view('pages.detalle-punto-interes', compact('item'))->with('tipo', 'Isla');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar museos
     */
    public function museos()
    {
        try {
            set_time_limit(120);

            // Obtener datos de la tabla tabla_museos con leftJoin a localidades
            $museos = \DB::table('tabla_museos as m')
                ->leftJoin('tabla_localities as l', 'm.ID_LOCALITIES', '=', 'l.ID')
                ->select('m.*', 'l.MUNICIPIOS as localidad_nombre', 'l.DEPARTAMENTO as localidad_departamento')
                ->limit(50)
                ->get();

            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });

            // Array para rastrear imágenes usadas (evitar repeticiones)
            $usedImages = [];

            // Combinar con imágenes usando datos pre-cargados
            $items = $museos->map(function($item) use (&$usedImages, $imagenesMap) {
                // Obtener nombre de localidad desde el leftJoin
                $localidad = $item->localidad_nombre ?? null;
                $departamento = $item->localidad_departamento ?? null;

                // Obtener nombre y descripción de forma directa
                $nombre = $item->NOMBRE_MUSEO ?? 'Museo';
                $descripcion = $item->DESCRIPCION ?? 'Sin descripción disponible';
                $id = $item->ID_MUSEO ?? null;

                // Buscar imagen usando ImageHelper con deduplicación
                $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);
                
                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }

                $museo_con_imagen = (object)[
                    'id' => $id,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'ubicacion' => $localidad ?? 'Colombia',
                    'imagen' => $imagenData['url']
                ];

                return $museo_con_imagen;
            });

            // Log del primer item para debug
            if ($items->count() > 0) {
                $primerItem = $items->first();
                \Log::info('Primer item: nombre=' . ($primerItem->nombre ?? 'null') . ', imagen=' . ($primerItem->imagen ?? 'null') . ', id=' . ($primerItem->id ?? 'null'));
            }

            return view('pages.museos', compact('items'));
        } catch (\Exception $e) {
            \Log::error('Error en museos: ' . $e->getMessage());
            return view('pages.museos', [
                'items' => collect([]),
                'error' => 'Error al cargar museos: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar parques temáticos
     */
    public function parquesTematicos()
    {
        try {
            // Obtener datos de la tabla tabla_parque_tematicos con leftJoin a localidades
            $parques = \DB::table('tabla_parque_tematicos as p')
                ->leftJoin('tabla_localities as l', 'p.ID_LOCALITIES', '=', 'l.ID')
                ->select('p.*', 'l.MUNICIPIOS as localidad_nombre', 'l.DEPARTAMENTO as localidad_departamento')
                ->get();
            
            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            // Array para rastrear imágenes usadas (evitar repeticiones)
            $usedImages = [];
            
            // Combinar con imágenes usando datos pre-cargados
            $items = $parques->map(function($item) use (&$usedImages, $imagenesMap) {
                // Obtener nombre de localidad desde el leftJoin
                $localidad = $item->localidad_nombre ?? null;
                $departamento = $item->localidad_departamento ?? null;
                
                // Buscar imagen usando ImageHelper con deduplicación
                $nombre = trim($item->NOMBRE_PARQUES_TEMÁTICOS ?? '');
                $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);
                
                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }
                
                $parque_con_imagen = (object)[
                    'id' => $item->ID_PARQUES,
                    'nombre' => $nombre ?: 'Parque temático',
                    'descripcion' => $item->DESCRIPCION ?? '',
                    'localidad' => $localidad,
                    'imagen' => $imagenData['url']
                ];
                
                return $parque_con_imagen;
            });
            
            return view('pages.parques-tematicos', compact('items'));
        } catch (\Exception $e) {
            return view('pages.parques-tematicos', [
                'items' => collect([]),
                'error' => 'La tabla de parques temáticos no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar playas
     */
    public function playas()
    {
        try {
            // Obtener datos de la tabla tabla_playas con leftJoin a localidades
            $playas = \DB::table('tabla_playas as p')
                ->leftJoin('tabla_localities as l', 'p.ID_LOCALITIES', '=', 'l.ID')
                ->select('p.*', 'l.MUNICIPIOS as localidad_nombre', 'l.DEPARTAMENTO as localidad_departamento')
                ->get();
            
            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            // Array para rastrear imágenes usadas (evitar repeticiones)
            $usedImages = [];
            
            // Combinar con imágenes usando datos pre-cargados
            $items = $playas->map(function($item) use (&$usedImages, $imagenesMap) {
                // Obtener nombre de localidad desde el leftJoin
                $localidad = $item->localidad_nombre ?? null;
                $departamento = $item->localidad_departamento ?? null;
                
                // Buscar imagen usando ImageHelper con deduplicación
                $nombre = trim($item->NOMBRE_PLAYA ?? '');
                $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);
                
                if ($imagenData['url']) {
                    $usedImages[] = $imagenData['url'];
                }
                
                $playa_con_imagen = (object)[
                    'id' => $item->ID_PLAYA,
                    'nombre' => $nombre ?: 'Playa',
                    'descripcion' => $item->DESCRIPCION ?? '',
                    'localidad' => $localidad,
                    'imagen' => $imagenData['url']
                ];
                
                return $playa_con_imagen;
            });
            
            return view('pages.playas', compact('items'));
        } catch (\Exception $e) {
            return view('pages.playas', [
                'items' => collect([]),
                'error' => 'La tabla de playas no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar reservas naturales
     */
    public function reservasNaturales()
    {
        // Obtener datos de la tabla tabla_reservas con leftJoin a tabla_localities
        // Relación: tabla_reservas.ID_REGIÓN = tabla_localities.REGION
        $reservas = \DB::table('tabla_reservas as r')
            ->leftJoin('tabla_localities as l', 'r.ID_REGIÓN', '=', 'l.REGION')
            ->select([
                'r.ID_RESERVAS',
                'r.NOMBRE_RESERVAS_O_PARQUES',
                'r.DESCRIPCION',
                'r.ID_REGIÓN',
                'l.MUNICIPIOS as localidad_municipio',
                'l.DEPARTAMENTO as localidad_departamento',
                'l.REGION as localidad_region'
            ])
            ->get();

        // Cargar imágenes en memoria una sola vez - CACHED
        $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
            return \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();
        });

        // Array para rastrear imágenes usadas (evitar repeticiones)
        $usedImages = [];

        // Combinar con imágenes usando datos pre-cargados
        $items = $reservas->map(function($item) use (&$usedImages, $imagenesMap) {
            // Buscar imagen usando ImageHelper con deduplicación
            $nombre = trim($item->NOMBRE_RESERVAS_O_PARQUES ?? '');
            $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);

            if ($imagenData['url']) {
                $usedImages[] = $imagenData['url'];
            }

            $reserva_con_imagen = (object)[
                'id' => $item->ID_RESERVAS,
                'nombre' => $nombre ?: 'Reserva Natural',
                'descripcion' => $item->DESCRIPCION ?? '',
                'localidad_municipio' => $item->localidad_municipio,
                'localidad_departamento' => $item->localidad_departamento,
                'imagen' => $imagenData['url']
            ];

            return $reserva_con_imagen;
        });

        return view('pages.reservas-naturales', compact('items'));
    }

    /**
     * Mostrar fiestas y ferias
     */
    public function fiestasFerias()
    {
        try {
            // Obtener datos de la tabla tabla_ferias directamente
            $ferias = \DB::table('tabla_ferias')->get();
            
            // Verificar si hay datos
            if ($ferias->isEmpty()) {
                return view('pages.fiestas-ferias', [
                    'items' => collect([]),
                    'error' => 'No se encontraron fiestas y ferias en la base de datos. La tabla tabla_ferias está vacía.'
                ]);
            }
            
            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            // Combinar con imágenes usando datos pre-cargados
            $items = $ferias->map(function($feria) use ($imagenesMap) {
                // Convertir a array para acceder a las propiedades
                $feriaArray = (array)$feria;
                
                // Obtener nombre dinámicamente
                $nombre = null;
                foreach ($feriaArray as $key => $value) {
                    if (stripos($key, 'nombre') !== false) {
                        $nombre = $value;
                        break;
                    }
                }
                
                // Buscar imagen usando mapa en memoria (evitar query en loop)
                $imagen = null;
                if (!empty($nombre)) {
                    $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
                    
                    // Buscar coincidencia exacta
                    $imagenExacta = $imagenesMap->firstWhere('NOMBRE_IMAGEN', $nombre);
                    if ($imagenExacta) {
                        $imagen = $imagenExacta->RUTA;
                    } else {
                        // Buscar coincidencia normalizada
                        foreach ($imagenesMap as $img) {
                            $nombreImgNormalizado = \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN);
                            if ($nombreImgNormalizado === $nombreNormalizado) {
                                $imagen = $img->RUTA;
                                break;
                            }
                        }
                    }
                }
                
                $feria_con_imagen = (object)[
                    'id' => $feria->ID_FERIAS ?? $feria->id,
                    'nombre' => $nombre ?? 'Fiesta o feria',
                    'descripcion' => $feria->DESCRIPCION ?? '',
                    'localidad' => null,
                    'imagen' => $imagen
                ];
                
                return $feria_con_imagen;
            });
            
            return view('pages.fiestas-ferias', compact('items'));
        } catch (\Exception $e) {
            return view('pages.fiestas-ferias', [
                'items' => collect([]),
                'error' => 'Error al cargar fiestas y ferias: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Mostrar termales
     */
    public function termales()
    {
        try {
            // Obtener datos de la tabla tabla_termales
            $termales = \DB::table('tabla_termales')->get();
            
            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            // Combinar con imágenes usando datos pre-cargados
            $items = $termales->map(function($termal) use ($imagenesMap) {
                // Buscar imagen usando mapa en memoria (evitar query en loop)
                $nombre = trim($termal->NOMBRE_TERMAL ?? '');
                $imagen = null;
                
                if (!empty($nombre)) {
                    $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
                    
                    // Buscar coincidencia exacta
                    $imagenExacta = $imagenesMap->firstWhere('NOMBRE_IMAGEN', $nombre);
                    if ($imagenExacta) {
                        $imagen = $imagenExacta->RUTA;
                    } else {
                        // Buscar coincidencia normalizada
                        foreach ($imagenesMap as $img) {
                            $nombreImgNormalizado = \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN);
                            if ($nombreImgNormalizado === $nombreNormalizado) {
                                $imagen = $img->RUTA;
                                break;
                            }
                        }
                    }
                }
                
                $termal_con_imagen = (object)[
                    'id' => $termal->ID_TERMALES,
                    'nombre' => $nombre ?: 'Termales',
                    'descripcion' => $termal->DESCRIPCION ?? '',
                    'localidad' => null,
                    'imagen' => $imagen
                ];
                
                return $termal_con_imagen;
            });
            
            return view('pages.termales', compact('items'));
        } catch (\Exception $e) {
            // Si la tabla no existe, mostrar mensaje de error
            return view('pages.termales', [
                'items' => collect([]),
                'error' => 'La tabla de termales no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar actividades en parques
     */
    public function actividadesParques()
    {
        try {
            set_time_limit(120);
            
            // Log inicial
            \Log::info('INICIO actividadesParques - Cargando desde BD');
            
            // Obtener datos de la tabla tabla_actividad_parque con nombres de columna correctos
            $actividades = \DB::table('tabla_actividad_parque')->orderBy('ID_ACTIVIDAD')->get();
            
            // Log de datos crudos
            \Log::info('Datos crudos de tabla_actividad_parque', [
                'count' => $actividades->count(),
                'first' => $actividades->first()
            ]);
            
            // Calcular stats reales
            $totalActividades = $actividades->count();
            $totalLocalidades = 0;
            $totalConImagen = 0;
            
            // Verificar si la tabla localities existe antes de consultar
            $localidadesTableExists = \Schema::hasTable('tabla_localities');
            
            // Obtener todas las localidades en una sola consulta solo si la tabla existe
            $localidadesData = [];
            if ($localidadesTableExists) {
                $localidadesIds = $actividades->pluck('ID_LOCALITITES')->filter()->unique()->toArray();
                if (!empty($localidadesIds)) {
                    $localidadesData = \DB::table('tabla_localities')
                        ->whereIn('ID_LOCALITIES', $localidadesIds)
                        ->get()
                        ->keyBy('ID_LOCALITIES');
                    $totalLocalidades = count($localidadesData);
                }
            }
            
            // Combinar con imágenes y localidades
            $index = 0;
            $items = $actividades->map(function($actividad) use ($localidadesData, $localidadesTableExists, &$index) {
                // Log para debug de cada actividad
                if ($index === 0) {
                    \Log::info('Primera actividad procesada', [
                        'id' => $actividad->ID_ACTIVIDAD,
                        'nombre' => $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE,
                        'descripcion' => $actividad->DESCRIPCION
                    ]);
                }
                
                // Obtener nombre de localidad desde cache
                $localidad = null;
                $departamento = null;
                if ($localidadesTableExists && !empty($actividad->ID_LOCALITITES) && isset($localidadesData[$actividad->ID_LOCALITITES])) {
                    $loc = $localidadesData[$actividad->ID_LOCALITITES];
                    $localidad = $loc->NOMBRE_LOCALITIES ?? null;
                    
                    // Obtener departamento si existe localidad
                    if (!empty($loc->ID_DEPARTAMENTO)) {
                        $dept = \DB::table('tabla_departamentos')->where('ID_DEPARTAMENTO', $loc->ID_DEPARTAMENTO)->first();
                        $departamento = $dept ? $dept->NOMBRE_DEPARTAMENTO : null;
                    }
                }
                
                // Generar slug en memoria solo si no existe en BD
                $slug = $actividad->slug ?? \Illuminate\Support\Str::slug($actividad->NOMBRE_ACTIVIDAD_EN_PARQUE ?? 'actividad');
                
                // Imagen: usar ImageHelper para buscar imagen real desde tabla_imagenes
                $imagen = \App\Helpers\ImageHelper::getCategoriaImage('actividad_parque', $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE);
                
                // Generar etiquetas dinámicas basadas en el nombre
                $tags = \App\Helpers\ImageHelper::getActivityTags($actividad->NOMBRE_ACTIVIDAD_EN_PARQUE);
                
                // Log para debug de imagen en listado
                if ($index === 0) { // Solo loguear el primero para no saturar
                    \Log::info('Actividad parque listado imagen', [
                        'id' => $actividad->ID_ACTIVIDAD,
                        'nombre' => $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE,
                        'imagen_url' => $imagen,
                        'tiene_imagen' => !empty($imagen),
                        'tags' => $tags
                    ]);
                }
                
                $actividad_con_imagen = (object)[
                    'id' => $actividad->ID_ACTIVIDAD,
                    'nombre' => $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE ?? 'Actividad en parque',
                    'descripcion' => $actividad->DESCRIPCION ?? '',
                    'localidad' => $localidad,
                    'departamento' => $departamento,
                    'slug' => $slug,
                    'imagen' => $imagen,
                    'tags' => $tags
                ];
                
                $index++;
                return $actividad_con_imagen;
            });
            
            // Calcular stats útiles
            $totalConImagen = $items->filter(function($item) {
                return !empty($item->imagen);
            })->count();
            
            // Log para debug
            \Log::info('Actividades en parques cargadas', [
                'db_count' => $totalActividades,
                'mapped_count' => $items->count(),
                'localidades' => $totalLocalidades,
                'first_item' => $items->first()
            ]);
            
            return view('pages.actividades-parques', compact('items'))->with([
                'stats' => [
                    'actividades' => $totalActividades,
                    'con_imagen' => $totalConImagen,
                    'experiencias' => $totalActividades,
                    'localidades' => $totalLocalidades
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en actividadesParques: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return view('pages.actividades-parques', [
                'items' => collect([]),
                'stats' => [
                    'actividades' => 0,
                    'localidades' => 0,
                    'experiencias' => 0
                ],
                'error' => 'La tabla de actividades en parques no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar detalle de actividad en parque
     */
    public function actividadesParquesShow($id)
    {
        try {
            // Buscar directamente por ID ya que la tabla no tiene columna slug
            $actividad = \DB::table('tabla_actividad_parque')->where('ID_ACTIVIDAD', $id)->first();
            
            if (!$actividad) {
                abort(404);
            }
            
            // Verificar si la tabla localities existe
            $localidadesTableExists = \Schema::hasTable('tabla_localities');
            
            // Obtener nombre de localidad
            $localidad = null;
            $departamento = null;
            if ($localidadesTableExists && !empty($actividad->ID_LOCALITITES)) {
                $loc = \DB::table('tabla_localities')->where('ID', $actividad->ID_LOCALITITES)->first();
                $localidad = $loc ? $loc->MUNICIPIOS : null;
                
                // Obtener departamento si existe localidad
                if ($loc && !empty($loc->ID_DEPARTAMENTO)) {
                    $dept = \DB::table('tabla_departamentos')->where('ID_DEPARTAMENTO', $loc->ID_DEPARTAMENTO)->first();
                    $departamento = $dept ? $dept->NOMBRE_DEPARTAMENTO : null;
                }
            }
            
            // Buscar imagen en tabla_imagenes usando ImageHelper
            $imagen = \App\Helpers\ImageHelper::getCategoriaImage('actividad_parque', $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE);
            
            // Log para debug de imagen
            \Log::info('Actividad parque imagen resuelta', [
                'id' => $actividad->ID_ACTIVIDAD,
                'nombre' => $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE,
                'imagen_url' => $imagen,
                'tiene_imagen' => !empty($imagen)
            ]);
            
            // Obtener actividades relacionadas (mismo municipio)
            $actividadesRelacionadas = collect([]);
            if ($localidadesTableExists && !empty($actividad->ID_LOCALITITES)) {
                $relacionadas = \DB::table('tabla_actividad_parque')
                    ->where('ID_LOCALITITES', $actividad->ID_LOCALITITES)
                    ->where('ID_ACTIVIDAD', '!=', $actividad->ID_ACTIVIDAD)
                    ->limit(4)
                    ->get();
                
                $actividadesRelacionadas = $relacionadas->map(function($rel) {
                    $relImagen = \App\Helpers\ImageHelper::getCategoriaImage('actividad_parque', $rel->NOMBRE_ACTIVIDAD_EN_PARQUE);
                    
                    return (object)[
                        'id' => $rel->ID_ACTIVIDAD,
                        'nombre' => $rel->NOMBRE_ACTIVIDAD_EN_PARQUE,
                        'slug' => \Illuminate\Support\Str::slug($rel->NOMBRE_ACTIVIDAD_EN_PARQUE),
                        'imagen' => $relImagen
                    ];
                });
            }
            
            // Generar etiquetas dinámicas para el detalle
            $tags = \App\Helpers\ImageHelper::getActivityTags($actividad->NOMBRE_ACTIVIDAD_EN_PARQUE);
            
            $item = (object)[
                'id' => $actividad->ID_ACTIVIDAD,
                'nombre' => $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE,
                'descripcion' => $actividad->DESCRIPCION,
                'localidad' => $localidad,
                'departamento' => $departamento,
                'slug' => \Illuminate\Support\Str::slug($actividad->NOMBRE_ACTIVIDAD_EN_PARQUE),
                'imagen' => $imagen,
                'actividades_relacionadas' => $actividadesRelacionadas,
                'recomendaciones' => null, // No hay columna de recomendaciones en tabla_actividad_parque
                'tags' => $tags
            ];
            
            // Log para debug de recomendaciones
            \Log::info('Actividad parque recomendaciones', [
                'id' => $actividad->ID_ACTIVIDAD,
                'nombre' => $actividad->NOMBRE_ACTIVIDAD_EN_PARQUE,
                'tiene_recomendaciones' => false,
                'motivo' => 'No existe columna de recomendaciones en tabla_actividad_parque'
            ]);
            
            return view('pages.actividades-parques-detalle', compact('item'))->with('tipo', 'Actividad en Parque');
        } catch (\Exception $e) {
            \Log::error('Error en actividadesParquesShow: ' . $e->getMessage());
            abort(404);
        }
    }

    /**
     * Mostrar detalle de deporte de aventura
     */
    public function deportesAventuraShow($slug)
    {
        try {
            $deporte = \DB::table('tabla_deporte_aventura')->where('slug', $slug)->first();

            if (!$deporte) {
                \Log::warning('Deporte aventura no encontrado', ['slug' => $slug]);
                abort(404);
            }

            // Obtener nombre de municipio
            $localidad = null;
            if (!empty($deporte->ID_LOCALITIES) && \Schema::hasTable('tabla_municipios')) {
                try {
                    $municipio = \DB::table('tabla_municipios')->where('ID_MUNICIPIOS', $deporte->ID_LOCALITIES)->first();
                    $localidad = $municipio ? $municipio->NOMBRE_MUNICIPIOS : null;
                } catch (\Exception $e) {
                    $localidad = null;
                }
            }

            // Buscar imagen en tabla_imagenes
            $imagen = $this->buscarImagen($deporte->NOMBRE_DEPORTES_AVENTURA, 'deporte');

            // Cargar relacionados (máximo 4)
            $relacionados = collect();
            try {
                $relacionados = \DB::table('tabla_deporte_aventura')
                    ->where('ID_DEPORTES', '!=', $deporte->ID_DEPORTES)
                    ->limit(4)
                    ->get();

                // Cargar mapa de imágenes para relacionados
                $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                    return \DB::table('tabla_imagenes')
                        ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                        ->get();
                });

                $municipiosMap = collect();
                if (\Schema::hasTable('tabla_municipios')) {
                    $municipiosMap = \DB::table('tabla_municipios')
                        ->select('ID_MUNICIPIOS', 'NOMBRE_MUNICIPIOS')
                        ->get()
                        ->keyBy('ID_MUNICIPIOS');
                }

                $usedImages = [$imagen];
                $relacionados = $relacionados->map(function($rel) use (&$usedImages, $imagenesMap, $municipiosMap) {
                    $nombre = trim($rel->NOMBRE_DEPORTES_AVENTURA ?? '');
                    $loc = null;
                    if (!empty($rel->ID_LOCALITIES) && isset($municipiosMap[$rel->ID_LOCALITIES])) {
                        $loc = $municipiosMap[$rel->ID_LOCALITIES]->NOMBRE_MUNICIPIOS;
                    }

                    $imagenData = \App\Helpers\ImageHelper::getReservaParqueImage($nombre, $usedImages, $imagenesMap);
                    if ($imagenData['url']) {
                        $usedImages[] = $imagenData['url'];
                    }

                    return (object)[
                        'id' => $rel->ID_DEPORTES,
                        'nombre' => $nombre ?: 'Deporte de aventura',
                        'descripcion' => $rel->DESCRIPCION ?? '',
                        'localidad' => $loc,
                        'imagen' => $imagenData['url'],
                        'slug' => $rel->slug ?? \Illuminate\Support\Str::slug($nombre ?: 'deporte')
                    ];
                })->filter(fn ($item) => !empty($item->nombre));
            } catch (\Exception $e) {
                \Log::error('Error cargando relacionados: ' . $e->getMessage());
            }

            \Log::info('Deporte aventura show solicitado', [
                'slug' => $slug,
                'nombre' => $deporte->NOMBRE_DEPORTES_AVENTURA,
                'relacionados_count' => $relacionados->count()
            ]);

            $item = (object)[
                'id' => $deporte->ID_DEPORTES,
                'nombre' => trim($deporte->NOMBRE_DEPORTES_AVENTURA ?? ''),
                'descripcion' => $deporte->DESCRIPCION,
                'localidad' => $localidad,
                'imagen' => $imagen,
                'slug' => $deporte->slug
            ];

            return view('pages.deportes-aventura-detalle', compact('item', 'relacionados'));
        } catch (\Exception $e) {
            \Log::error('Error en deportesAventuraShow: ' . $e->getMessage());
            abort(404);
        }
    }

    /**
     * Mostrar detalle de desierto o laguna
     */
    public function desiertosLagunasShow($id)
    {
        try {
            $desierto = \DB::table('tabla_desierto_laguna')->where('ID_DESIERTO', $id)->first();
            
            if (!$desierto) {
                abort(404);
            }
            
            // Obtener nombre de localidad
            $localidad = null;
            if (!empty($desierto->ID_LOCALITIES)) {
                $loc = \DB::table('tabla_localities')->where('ID', $desierto->ID_LOCALITIES)->first();
                $localidad = $loc ? $loc->MUNICIPIOS : null;
            }
            
            $item = (object)[
                'id' => $desierto->ID_DESIERTO,
                'nombre' => $desierto->NOMBRE_DESIERTO_LAGUNAS,
                'descripcion' => $desierto->DESCRIPCION,
                'localidad' => $localidad,
                'imagen' => $this->buscarImagen($desierto->NOMBRE_DESIERTO_LAGUNAS, 'desierto')
            ];
            
            return view('pages.detalle-punto-interes', compact('item'))->with('tipo', 'Desierto o Laguna');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar detalle de iglesia
     */
    public function iglesiasShow($id)
    {
        try {
            $iglesia = \DB::table('tabla_iglesias')->where('ID_IGLESIA', $id)->first();
            
            if (!$iglesia) {
                abort(404);
            }
            
            // Obtener nombre de localidad
            $localidad = null;
            if (!empty($iglesia->ID_LOCALITIES)) {
                $loc = \DB::table('tabla_localities')->where('ID', $iglesia->ID_LOCALITIES)->first();
                $localidad = $loc ? $loc->MUNICIPIOS : null;
            }
            
            $item = (object)[
                'id' => $iglesia->ID_IGLESIA,
                'nombre' => $iglesia->NOMBRE_IGLESIA,
                'descripcion' => $iglesia->DESCRIPCION,
                'localidad' => $localidad,
                'imagen' => $this->buscarImagen($iglesia->NOMBRE_IGLESIA, 'iglesia')
            ];
            
            return view('pages.detalle-punto-interes', compact('item'))->with('tipo', 'Iglesia');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar detalle de museo
     */
    public function museosShow($id)
    {
        try {
            set_time_limit(60);

            // Intentar buscar por diferentes columnas de ID
            $museo = \DB::table('tabla_museos')->where('ID_MUSEO', $id)->first();

            if (!$museo) {
                $museo = \DB::table('tabla_museos')->where('id_museo', $id)->first();
            }

            if (!$museo) {
                abort(404);
            }

            // Obtener todas las columnas disponibles
            $columnas = array_keys((array)$museo);

            // Obtener nombre dinámicamente
            $nombre = null;
            foreach ($columnas as $col) {
                if (stripos($col, 'nombre') !== false) {
                    $nombre = $museo->$col;
                    break;
                }
            }

            // Obtener descripción dinámicamente
            $descripcion = null;
            foreach ($columnas as $col) {
                if (stripos($col, 'desc') !== false) {
                    $descripcion = $museo->$col;
                    break;
                }
            }

            // Obtener ID dinámicamente
            $id_real = null;
            foreach ($columnas as $col) {
                if (stripos($col, 'id') !== false && $col !== 'id_localities' && $col !== 'id_country') {
                    $id_real = $museo->$col;
                    break;
                }
            }

            // Obtener ubicación si existe id_localities
            $ubicacion = 'Colombia';
            if (isset($museo->id_localities) && $museo->id_localities) {
                $municipio = \DB::table('tabla_municipios')->where('ID_MUNICIPIOS', $museo->id_localities)->first();
                if ($municipio) {
                    $departamento = \DB::table('tabla_departamentos')->where('ID_DEPARTAMENTO', $municipio->ID_DEPARTAMENTO)->first();
                    if ($departamento) {
                        $ubicacion = $municipio->NOMBRE_MUNICIPIOS . ', ' . $departamento->NOMBRE_DEPARTAMENTO;
                    } else {
                        $ubicacion = $municipio->NOMBRE_MUNICIPIOS;
                    }
                }
            }

            // Buscar imagen en tabla_imagenes
            $imagen = $this->buscarImagen($nombre ?? '', 'museo');

            // Crear objeto con datos principales
            $item = (object)[
                'id' => $id_real ?? $museo->{'ID_MUSEO'} ?? null,
                'nombre' => $nombre ?? 'Sin nombre',
                'descripcion' => $descripcion ?? 'Sin descripción disponible',
                'imagen' => $imagen,
                'ubicacion' => $ubicacion,
                'id_localities' => $museo->id_localities ?? null
            ];

            // Agregar TODAS las demás columnas disponibles
            foreach ($columnas as $col) {
                if (!isset($item->$col) && $col !== 'ID_MUSEO') {
                    $item->$col = $museo->$col;
                }
            }

            return view('pages.detalle-museo', compact('item'))->with('tipo', 'Museo');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar detalle de parque temático
     */
    public function parquesTematicosShow($id)
    {
        try {
            $parque = \DB::table('tabla_parque_tematicos')->where('ID_PARQUES', $id)->first();
            
            if (!$parque) {
                abort(404);
            }
            
            // Obtener nombre de localidad
            $localidad = null;
            if (!empty($parque->ID_LOCALITIES)) {
                $loc = \DB::table('tabla_localities')->where('ID_LOCALITIES', $parque->ID_LOCALITIES)->first();
                $localidad = $loc ? $loc->MUNICIPIOS : null;
            }
            
            $item = (object)[
                'id' => $parque->ID_PARQUES,
                'nombre' => $parque->NOMBRE_PARQUES_TEMÁTICOS,
                'descripcion' => $parque->DESCRIPCION,
                'localidad' => $localidad,
                'imagen' => $this->buscarImagen($parque->NOMBRE_PARQUES_TEMÁTICOS, 'parque')
            ];
            
            return view('pages.detalle-punto-interes', compact('item'))->with('tipo', 'Parque Temático');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar detalle de playa
     */
    public function playasShow($id)
    {
        try {
            $playa = \DB::table('tabla_playas')->where('ID_PLAYA', $id)->first();
            
            if (!$playa) {
                abort(404);
            }
            
            // Obtener nombre de localidad - verificar si tabla existe
            $localidad = null;
            if (!empty($playa->ID_LOCALITIES) && \Schema::hasTable('tabla_localities')) {
                $loc = \DB::table('tabla_localities')->where('ID_LOCALITIES', $playa->ID_LOCALITIES)->first();
                $localidad = $loc ? $loc->MUNICIPIOS : null;
            }
            
            $item = (object)[
                'id' => $playa->ID_PLAYA,
                'nombre' => $playa->NOMBRE_PLAYA,
                'descripcion' => $playa->DESCRIPCION,
                'localidad' => $localidad,
                'imagen' => $this->buscarImagen($playa->NOMBRE_PLAYA, 'playa')
            ];
            
            return view('pages.detalle-punto-interes', compact('item'))->with('tipo', 'Playa');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar detalle de reserva natural
     */
    public function reservasNaturalesShow($id)
    {
        $reserva = \DB::table('tabla_reservas')->where('ID_RESERVAS', $id)->first();

        if (!$reserva) {
            abort(404);
        }

        // NOTA: tabla_reservas tiene ID_REGIÓN, no ID_LOCALITIES
        // Usar ID_REGIÓN como localidad
        $localidad = $reserva->ID_REGIÓN ?? null;

        $item = (object)[
            'id' => $reserva->ID_RESERVAS,
            'nombre' => $reserva->NOMBRE_RESERVAS_O_PARQUES,
            'descripcion' => $reserva->DESCRIPCION,
            'localidad' => $localidad,
            'imagen' => $this->buscarImagen($reserva->NOMBRE_RESERVAS_O_PARQUES, 'reserva')
        ];

        return view('pages.detalle-punto-interes', compact('item'))->with('tipo', 'Reserva Natural');
    }

    /**
     * Mostrar detalle de termal
     */
    public function termalesShow($id)
    {
        try {
            $termal = \DB::table('tabla_termales')->where('ID_TERMALES', $id)->first();
            
            if (!$termal) {
                abort(404);
            }
            
            // Obtener nombre de localidad
            $localidad = null;
            if (!empty($termal->ID_LOCALITIES)) {
                $loc = \DB::table('tabla_localities')->where('ID', $termal->ID_LOCALITIES)->first();
                $localidad = $loc ? $loc->MUNICIPIOS : null;
            }
            
            $item = (object)[
                'id' => $termal->ID_TERMALES,
                'nombre' => $termal->NOMBRE_TERMAL,
                'descripcion' => $termal->DESCRIPCION,
                'localidad' => $localidad,
                'imagen' => $this->buscarImagen($termal->NOMBRE_TERMAL, 'termal')
            ];
            
            return view('pages.detalle-punto-interes', compact('item'))->with('tipo', 'Termales');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Mostrar regiones
     */
    public function regiones()
    {
        try {
            // Datos reales de regiones de Colombia
            $regionesData = [
                [
                    'id' => 1,
                    'nombre' => 'Región Andina',
                    'descripcion' => 'Corazón de Colombia con los Andes, café, cultura y ciudades históricas como Bogotá, Medellín y Cali.',
                    'departamentos' => 'Cundinamarca, Antioquia, Valle del Cauca, Quindío, Risaralda, Caldas, Tolima, Huila, Boyacá'
                ],
                [
                    'id' => 2,
                    'nombre' => 'Región Caribe',
                    'descripcion' => 'Costa caribeña con playas, música vallenata, cumbia y ciudades como Cartagena, Barranquilla y Santa Marta.',
                    'departamentos' => 'Atlántico, Bolívar, Cesar, Córdoba, La Guajira, Magdalena, Sucre'
                ],
                [
                    'id' => 3,
                    'nombre' => 'Región Pacífica',
                    'descripcion' => 'Litoral pacífico con selva húmeda, biodiversidad, cultura afro y puertos como Buenaventura y Tumaco.',
                    'departamentos' => 'Chocó, Valle del Cauca (costa pacífica), Cauca, Nariño'
                ],
                [
                    'id' => 4,
                    'nombre' => 'Región Orinoquía',
                    'descripcion' => 'Llanos orientales con sabanas, ganadería, joropadas y petróleo. Tierra de llaneros y música llanera.',
                    'departamentos' => 'Meta, Casanare, Arauca, Vichada, Guainía, Guaviare'
                ],
                [
                    'id' => 5,
                    'nombre' => 'Región Amazonía',
                    'descripcion' => 'Selva amazónica con increíble biodiversidad, comunidades indígenas, ríos y naturaleza virgen.',
                    'departamentos' => 'Amazonas, Vaupés, Putumayo, Caquetá, Guaviare'
                ],
                [
                    'id' => 6,
                    'nombre' => 'Región Insular',
                    'descripcion' => 'Islas caribeñas con playas paradisíacas, turismo y cultura única en San Andrés, Providencia y Santa Catalina.',
                    'departamentos' => 'San Andrés y Providencia'
                ]
            ];
            
            // Convertir a colección de objetos y buscar imágenes
            $items = collect($regionesData)->map(function($region) {
                $region['imagen'] = $this->buscarImagen($region['nombre'], 'region');
                return (object)$region;
            });
            
            return view('pages.regiones', compact('items'));
        } catch (\Exception $e) {
            return view('pages.regiones', [
                'items' => collect([]),
                'error' => 'La información de regiones no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar ciclismo
     */
    public function ciclismo()
    {
        try {
            // Obtener datos de la tabla tabla_ciclismo con leftJoin a localidades
            $ciclismo = \DB::table('tabla_ciclismo as c')
                ->leftJoin('tabla_localities as l', 'c.ID_LOCALITIES', '=', 'l.ID')
                ->select('c.*', 'l.MUNICIPIOS as localidad_nombre', 'l.DEPARTAMENTO as localidad_departamento')
                ->get();
            
            // Cargar imágenes en memoria una sola vez - CACHED
            $imagenesMap = \Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            // Usar mapa de imágenes para obtener imágenes desde tabla_imagenes
            $items = $ciclismo->map(function($ruta) use ($imagenesMap) {
                // Obtener nombre de localidad desde el leftJoin
                $localidad = $ruta->localidad_nombre ?? null;
                $departamento = $ruta->localidad_departamento ?? null;
                
                // Buscar imagen usando mapa en memoria (evitar query en loop)
                $nombre = trim($ruta->NOMBRE_RUTA_CICLISMO ?? '');
                $imagen = null;
                
                if (!empty($nombre)) {
                    $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
                    
                    // Buscar coincidencia exacta
                    $imagenExacta = $imagenesMap->firstWhere('NOMBRE_IMAGEN', $nombre);
                    if ($imagenExacta) {
                        $imagen = $imagenExacta->RUTA;
                    } else {
                        // Buscar coincidencia normalizada
                        foreach ($imagenesMap as $img) {
                            $nombreImgNormalizado = \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN);
                            if ($nombreImgNormalizado === $nombreNormalizado) {
                                $imagen = $img->RUTA;
                                break;
                            }
                        }
                    }
                }
                
                $ruta_con_imagen = (object)[
                    'id' => $ruta->ID_CICLISMO,
                    'nombre' => $ruta->NOMBRE_RUTA_CICLISMO ?? 'Ruta de ciclismo',
                    'descripcion' => $ruta->DESCRIPCION ?? '',
                    'localidad' => $localidad,
                    'imagen' => $imagen,
                    'slug' => $ruta->slug ?? \Illuminate\Support\Str::slug($ruta->NOMBRE_RUTA_CICLISMO ?? 'ruta')
                ];
                
                return $ruta_con_imagen;
            });
            
            return view('pages.ciclismo', compact('items'));
        } catch (\Exception $e) {
            return view('pages.ciclismo', [
                'items' => collect([]),
                'error' => 'La tabla de ciclismo no está disponible en este momento.'
            ]);
        }
    }

    /**
     * Mostrar detalle de ruta de ciclismo
     */
    public function showCiclismo($slug)
    {
        try {
            $ruta = \DB::table('tabla_ciclismo')->where('slug', $slug)->first();
            
            if (!$ruta) {
                abort(404);
            }
            
            // Obtener nombre de localidad
            $localidad = null;
            if (!empty($ruta->ID_LOCALITIES)) {
                try {
                    $loc = \DB::table('tabla_localities')->where('ID', $ruta->ID_LOCALITIES)->first();
                    $localidad = $loc ? $loc->MUNICIPIOS : null;
                } catch (\Exception $e) {
                    $localidad = null;
                }
            }
            
            // Buscar imagen en tabla_imagenes
            $imagen = $this->buscarImagen($ruta->NOMBRE_RUTA_CICLISMO, 'ciclismo');
            
            $route = (object)[
                'id' => $ruta->ID_CICLISMO,
                'nombre' => $ruta->NOMBRE_RUTA_CICLISMO ?? 'Ruta de ciclismo',
                'descripcion' => $ruta->DESCRIPCION ?? '',
                'localidad' => $localidad,
                'imagen' => $imagen,
                'slug' => $ruta->slug
            ];
            
            return view('pages.ciclismo-detalle', compact('route'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
