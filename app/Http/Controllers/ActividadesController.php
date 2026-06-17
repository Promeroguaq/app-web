<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ActividadesController extends Controller
{
    /**
     * Cargar todas las imágenes en bulk para evitar N+1 queries
     */
    private function cargarImagenesBulk($nombresActividades, $tipos = [])
    {
        try {
            // Obtener todas las imágenes relevantes en una sola consulta - CACHED
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')->get();
            });
            $imagenMap = [];
            
            foreach ($imagenes as $imagen) {
                $nombreImagen = strtolower($imagen->NOMBRE_IMAGEN);
                $rutaImagen = strtolower($imagen->RUTA);
                
                // Crear mapa de imágenes para búsqueda rápida
                $imagenMap[$nombreImagen] = $imagen->RUTA;
                $imagenMap[$rutaImagen] = $imagen->RUTA;
            }
            
            return $imagenMap;
        } catch (\Exception $e) {
            return [];
        }
    }
    
    /**
     * Buscar imagen para un elemento usando el mapa precargado
     */
    private function buscarImagenOptimizada($nombre, $tipo, $imagenMap)
    {
        if (empty($imagenMap)) {
            return null;
        }
        
        $nombreLower = strtolower($nombre);
        $nombreSlug = strtolower(str_replace(' ', '_', $nombre));
        $tipoLower = strtolower($tipo);
        
        // Búsqueda rápida en el mapa
        foreach ($imagenMap as $key => $ruta) {
            if (strpos($key, $nombreLower) !== false || 
                strpos($key, $nombreSlug) !== false ||
                (!empty($tipo) && strpos($key, $tipoLower) !== false)) {
                return $ruta;
            }
        }
        
        return null;
    }

    /**
     * Mostrar página de actividades con filtros y búsqueda (versión optimizada sin caché)
     */
    public function index(Request $request)
    {
        // Categorías simplificadas para mejor rendimiento
        $categorias = [
            'Actividades en parques',
            'Deportes de aventura',
            'Ciclismo',
            'Termales',
            'Playas',
            'Reservas naturales',
            'Museos',
            'Iglesias',
            'Parques temáticos'
        ];

        // Obtener departamentos con límite para evitar timeout (cache 1 hora)
        $departamentos = Cache::remember('act_deptos', 3600, function () {
            try {
                return Departamento::distinct()->orderBy('NOMBRE_DEPARTAMENTO')->limit(32)->get();
            } catch (\Exception $e) {
                return collect();
            }
        });
        
        // Obtener municipios con límite para evitar timeout (cache 1 hora)
        $municipios = Cache::remember('act_munic', 3600, function () {
            try {
                return Municipio::orderBy('NOMBRE_MUNICIPIOS')->limit(100)->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        $todasActividades = collect();

        // Lista de tablas a consultar con su configuración
        $tablas = [
            'tabla_actividad_parque' => [
                'id_field' => 'ID_ACTIVIDAD',
                'nombre_field' => 'NOMBRE_ACTIVIDAD_EN_PARQUE',
                'categoria' => 'Actividades en parques',
                'tipo' => 'actividad'
            ],
            'tabla_deporte_aventura' => [
                'id_field' => 'ID_DEPORTE',
                'nombre_field' => 'NOMBRE_DEPORTE',
                'categoria' => 'Deportes de aventura',
                'tipo' => 'deporte'
            ],
            'tabla_ciclismo' => [
                'id_field' => 'ID_CICLISMO',
                'nombre_field' => 'NOMBRE_CICLISMO',
                'categoria' => 'Ciclismo',
                'tipo' => 'ciclismo'
            ],
            'tabla_termales' => [
                'id_field' => 'ID_TERMAL',
                'nombre_field' => 'NOMBRE_TERMAL',
                'categoria' => 'Termales',
                'tipo' => 'termal'
            ],
            'tabla_playas' => [
                'id_field' => 'ID_PLAYA',
                'nombre_field' => 'nombre',
                'categoria' => 'Playas',
                'tipo' => 'playa'
            ],
            'tabla_reservas' => [
                'id_field' => 'ID_RESERVA',
                'nombre_field' => 'NOMBRE_RESERVA',
                'categoria' => 'Reservas naturales',
                'tipo' => 'reserva'
            ],
            'tabla_museos' => [
                'id_field' => 'id_museo',
                'nombre_field' => 'nombre_museo',
                'categoria' => 'Museos',
                'tipo' => 'museo'
            ],
            'tabla_iglesias' => [
                'id_field' => 'id_iglesia',
                'nombre_field' => 'nombre_iglesia',
                'categoria' => 'Iglesias',
                'tipo' => 'iglesia'
            ],
            'tabla_parque_tematicos' => [
                'id_field' => 'ID_PARQUE_TEMATICO',
                'nombre_field' => 'NOMBRE_PARQUE_TEMATICO',
                'categoria' => 'Parques temáticos',
                'tipo' => 'parque'
            ]
        ];

        // Precargar todas las imágenes en una sola consulta para evitar N+1
        $imagenMap = $this->cargarImagenesBulk([]);

        // Consultar cada tabla con límite de registros para evitar timeout
        foreach ($tablas as $tabla => $config) {
            try {
                // Consulta directa sin caché, con límite de 20 registros por tabla
                $datos = \DB::table($tabla)->limit(20)->get();

                foreach($datos as $item) {
                    $nombre = $item->{$config['nombre_field']} ?? $config['categoria'];
                    
                    $todasActividades->push((object)[
                        'id' => $item->{$config['id_field']} ?? uniqid(),
                        'nombre' => $nombre,
                        'descripcion' => $item->DESCRIPCION ?? $item->descripcion ?? '',
                        'categoria' => $config['categoria'],
                        'departamento' => $item->departamento ?? $item->DEPARTAMENTO ?? 'Colombia',
                        'municipio' => $item->municipio ?? $item->MUNICIPIO ?? '',
                        'tipo' => $config['tipo'],
                        'imagen' => $this->buscarImagenOptimizada($nombre, $config['tipo'], $imagenMap)
                    ]);
                }
            } catch (\Exception $e) {
                // Continuar con la siguiente tabla si hay error
                continue;
            }
        }

        // Aplicar filtros si existen
        $actividades = $todasActividades;

        if ($request->filled('busqueda')) {
            $actividades = $actividades->filter(function ($actividad) use ($request) {
                return stripos($actividad->nombre, $request->busqueda) !== false ||
                       stripos($actividad->descripcion, $request->busqueda) !== false ||
                       stripos($actividad->categoria, $request->busqueda) !== false;
            })->values();
        }

        if ($request->filled('categoria') && $request->categoria !== 'Todas las categorías') {
            $actividades = $actividades->filter(function ($actividad) use ($request) {
                return stripos($actividad->categoria, $request->categoria) !== false;
            })->values();
        }

        if ($request->filled('departamento') && $request->departamento !== 'Todos los departamentos') {
            $actividades = $actividades->filter(function ($actividad) use ($request) {
                return stripos($actividad->departamento, $request->departamento) !== false;
            })->values();
        }

        if ($request->filled('municipio') && $request->municipio !== 'Todos los municipios') {
            $actividades = $actividades->filter(function ($actividad) use ($request) {
                return stripos($actividad->municipio, $request->municipio) !== false;
            })->values();
        }

        // Preparar municipios para el filtro
        $municipiosFiltro = $municipios->pluck('NOMBRE_MUNICIPIOS')->values()->all();

        try {
            return view('pages.actividades', compact(
                'actividades',
                'departamentos',
                'municipios',
                'categorias',
                'municipiosFiltro'
            ));
        } catch (\Exception $e) {
            return view('pages.actividades', [
                'actividades' => collect([]),
                'departamentos' => collect([]),
                'municipios' => collect([]),
                'categorias' => [],
                'municipiosFiltro' => [],
                'error' => 'Error al cargar las actividades: ' . $e->getMessage()
            ]);
        }
    }
}
