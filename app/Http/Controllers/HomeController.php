<?php

namespace App\Http\Controllers;

use App\Models\ActividadParque;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Isla;
use App\Models\Playa;
use App\Models\Museo;
use App\Models\Iglesia;
use App\Models\DeporteAventura;
use App\Models\DesiertoLaguna;
use App\Models\ParqueTematico;
use App\Models\Termal;
use App\Models\Imagen;
use App\Models\PlatoTipico;
use App\Models\FeriaFiesta;
use App\Models\Ciclismo;
use App\Services\ImageResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Mostrar página principal
     */
        public function index()
        {
            // Usar caché para optimizar rendimiento
            $data = Cache::remember('home_data', 3600, function () {
                return $this->buildHomeData();
            });

            return redirect()->route('dashboard');
        }

    private function buildHomeData()
    {

        /*
        |--------------------------------------------------------------------------
        | ESTADÍSTICAS GENERALES
        |--------------------------------------------------------------------------
        */

        $totalIslas              = $this->contarModeloSeguro(Isla::class);
        $totalPlayas             = $this->contarModeloSeguro(Playa::class);
        $totalMuseos             = $this->contarModeloSeguro(Museo::class);
        $totalIglesias           = $this->contarModeloSeguro(Iglesia::class);
        $totalDeportes           = $this->contarModeloSeguro(DeporteAventura::class);
        $totalDesiertosLagunas   = $this->contarModeloSeguro(DesiertoLaguna::class);
        $totalParques            = $this->contarModeloSeguro(ParqueTematico::class);
        $totalTermales           = $this->contarModeloSeguro(Termal::class);

        $totalDestinos =
            $totalIslas +
            $totalPlayas +
            $totalMuseos +
            $totalIglesias +
            $totalDeportes +
            $totalDesiertosLagunas +
            $totalParques +
            $totalTermales;

        $stats = [
            'destinos'        => $totalDestinos,
            'departamentos'   => $this->contarModeloSeguro(Departamento::class),
            'actividades'     => $this->contarModeloSeguro(ActividadParque::class),
            'rutas'           => $this->contarModeloSeguro(Ciclismo::class),
            'turismo_religioso' => $totalIglesias,
            'eventos'         => $this->contarModeloSeguro(FeriaFiesta::class),
            'platos_tipicos'  => $this->contarModeloSeguro(PlatoTipico::class),
        ];


        /*
        |--------------------------------------------------------------------------
        | GRÁFICO TORTA
        |--------------------------------------------------------------------------
        */

        $destinosPorCategoria = [
            'Islas' => [
                'cantidad'   => $totalIslas,
                'porcentaje' => ($totalIslas * 100) / max(1, $totalDestinos)
            ],

            'Playas' => [
                'cantidad'   => $totalPlayas,
                'porcentaje' => ($totalPlayas * 100) / max(1, $totalDestinos)
            ],

            'Museos' => [
                'cantidad'   => $totalMuseos,
                'porcentaje' => ($totalMuseos * 100) / max(1, $totalDestinos)
            ],

            'Turismo Religioso' => [
                'cantidad'   => $totalIglesias,
                'porcentaje' => ($totalIglesias * 100) / max(1, $totalDestinos)
            ],

            'Deportes Aventura' => [
                'cantidad'   => $totalDeportes,
                'porcentaje' => ($totalDeportes * 100) / max(1, $totalDestinos)
            ],

            'Desiertos/Lagunas' => [
                'cantidad'   => $totalDesiertosLagunas,
                'porcentaje' => ($totalDesiertosLagunas * 100) / max(1, $totalDestinos)
            ],

            'Parques Temáticos' => [
                'cantidad'   => $totalParques,
                'porcentaje' => ($totalParques * 100) / max(1, $totalDestinos)
            ],

            'Termales' => [
                'cantidad'   => $totalTermales,
                'porcentaje' => ($totalTermales * 100) / max(1, $totalDestinos)
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | COMPARACIÓN POR DEPARTAMENTO
        |--------------------------------------------------------------------------
        */

        $departamentosGrafica = Departamento::orderBy('NOMBRE_DEPARTAMENTO')
            ->take(10)
            ->get();

        $comparacionPorDepartamento = [];

        foreach ($departamentosGrafica as $depto) {

            $comparacionPorDepartamento[] = [
                'departamento' => $depto->NOMBRE_DEPARTAMENTO,
                'destinos'     => $totalDestinos,
                'actividades'  => $this->contarModeloSeguro(ActividadParque::class),
                'hoteles'      => 0
            ];
        }


        $destinosDestacados = $this->obtenerDestinosDestacados();

        $explorarTipos = [
            [
                'nombre' => 'Actividades',
                'icono' => 'fas fa-campground',
                'clase' => 'stat-orange',
                'url' => route('actividades'),
                'imagen' => $this->buscarImagenEnTabla('actividades')
            ],
            [
                'nombre' => 'Gastronomía',
                'icono' => 'fas fa-utensils',
                'clase' => 'stat-brown',
                'url' => route('gastronomia'),
                'imagen' => $this->buscarImagenEnTabla('gastronomia')
            ],
            [
                'nombre' => 'Alojamiento',
                'icono' => 'far fa-building',
                'clase' => 'stat-blue',
                'url' => route('alojamiento'),
                'imagen' => $this->buscarImagenEnTabla('hotel')
            ],
            [
                'nombre' => 'Rutas',
                'icono' => 'far fa-compass',
                'clase' => 'stat-purple',
                'url' => route('rutas-turisticas'),
                'imagen' => $this->buscarImagenEnTabla('rutas')
            ],
            [
                'nombre' => 'Eventos',
                'icono' => 'far fa-calendar',
                'clase' => 'stat-cyan',
                'url' => route('destinos', ['categoria' => 'Ferias/Fiestas']),
                'imagen' => $this->buscarImagenEnTabla('ferias')
            ],
            [
                'nombre' => 'Agencias',
                'icono' => 'fas fa-globe',
                'clase' => 'stat-amber',
                'url' => route('destinos'),
                'imagen' => $this->buscarImagenEnTabla('agencias')
            ],
            [
                'nombre' => 'Departamentos',
                'icono' => 'far fa-map',
                'clase' => 'stat-green',
                'url' => route('departamentos.index'),
                'imagen' => $this->buscarImagenEnTabla('departamentos')
            ],
            [
                'nombre' => 'Categorías',
                'icono' => 'far fa-star',
                'clase' => 'stat-purple',
                'url' => route('destinos')
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | DEPARTAMENTOS
        |--------------------------------------------------------------------------
        */

        $departamentos = Departamento::orderBy('NOMBRE_DEPARTAMENTO')
            ->take(12)
            ->get();
        
        // Resolver imágenes en lote
        $departamentoNombres = $departamentos->pluck('NOMBRE_DEPARTAMENTO')->toArray();
        $departamentoImagenes = $this->resolveImagenesEnLote($departamentoNombres);
        
        $departamentos = $departamentos->map(function($depto) use ($departamentoImagenes) {
            $depto->imagen = $departamentoImagenes[$depto->NOMBRE_DEPARTAMENTO] ?? null;
            return $depto;
        });


        /*
        |--------------------------------------------------------------------------
        | MUNICIPIOS
        |--------------------------------------------------------------------------
        */

        $municipios = Municipio::orderBy('NOMBRE_MUNICIPIOS')
            ->take(12)
            ->get();
        
        // Resolver imágenes en lote
        $municipioNombres = $municipios->pluck('NOMBRE_MUNICIPIOS')->toArray();
        $municipioImagenes = $this->resolveImagenesEnLote($municipioNombres);
        
        $municipios = $municipios->map(function($municipio) use ($municipioImagenes) {
            $municipio->imagen = $municipioImagenes[$municipio->NOMBRE_MUNICIPIOS] ?? null;
            return $municipio;
        });


        /*
        |--------------------------------------------------------------------------
        | ACTIVIDADES
        |--------------------------------------------------------------------------
        */

        $actividades = ActividadParque::orderBy('NOMBRE_ACTIVIDAD_EN_PARQUE')
            ->take(12)
            ->get();
        
        // Resolver imágenes en lote
        $actividadNombres = $actividades->pluck('NOMBRE_ACTIVIDAD_EN_PARQUE')->toArray();
        $actividadImagenes = $this->resolveImagenesEnLote($actividadNombres);
        
        $actividades = $actividades->map(function($actividad) use ($actividadImagenes) {
            $actividad->imagen = $actividadImagenes[$actividad->NOMBRE_ACTIVIDAD_EN_PARQUE] ?? null;
            return $actividad;
        });

        /*
        |--------------------------------------------------------------------------
        | HOTELES DESTACADOS
        |--------------------------------------------------------------------------
        */

        // Hoteles destacados - manteniendo datos de ejemplo ya que no hay tabla de hoteles
        $hotelesDestacados = [
            [
                'id' => 1,
                'nombre' => 'Eco Hotel Tayrona',
                'ubicacion' => 'Santa Marta, Magdalena',
                'imagen' => $this->buscarImagenEnTabla('hotel tayrona'),
                'calificacion' => 4.9,
                'precio' => 245,
                'categoria' => 'Eco-Friendly'
            ],
            [
                'id' => 2,
                'nombre' => 'Beachfront Resort',
                'ubicacion' => 'Cartagena, Bolívar',
                'imagen' => $this->buscarImagenEnTabla('hotel cartagena'),
                'calificacion' => 4.8,
                'precio' => 320,
                'categoria' => 'Beachfront'
            ],
            [
                'id' => 3,
                'nombre' => 'Mountain Lodge',
                'ubicacion' => 'Salento, Quindío',
                'imagen' => $this->buscarImagenEnTabla('hotel salento'),
                'calificacion' => 4.7,
                'precio' => 180,
                'categoria' => 'Mountain'
            ],
            [
                'id' => 4,
                'nombre' => 'Jungle Eco Resort',
                'ubicacion' => 'Leticia, Amazonas',
                'imagen' => $this->buscarImagenEnTabla('hotel amazonas'),
                'calificacion' => 4.6,
                'precio' => 195,
                'categoria' => 'Eco-Friendly'
            ],
            [
                'id' => 5,
                'nombre' => 'Colonial Boutique Hotel',
                'ubicacion' => 'Popayán, Cauca',
                'imagen' => $this->buscarImagenEnTabla('hotel popayan'),
                'calificacion' => 4.8,
                'precio' => 165,
                'categoria' => 'Boutique'
            ],
            [
                'id' => 6,
                'nombre' => 'Coffee Valley Inn',
                'ubicacion' => 'Armenia, Quindío',
                'imagen' => $this->buscarImagenEnTabla('hotel armenia'),
                'calificacion' => 4.7,
                'precio' => 140,
                'categoria' => 'Eje Cafetero'
            ],
            [
                'id' => 7,
                'nombre' => 'Pacific Beach Resort',
                'ubicacion' => 'Nuquí, Chocó',
                'imagen' => $this->buscarImagenEnTabla('hotel nuqui'),
                'calificacion' => 4.5,
                'precio' => 210,
                'categoria' => 'Beachfront'
            ],
            [
                'id' => 8,
                'nombre' => 'Desert Oasis Lodge',
                'ubicacion' => 'Villa de Leyva, Boyacá',
                'imagen' => $this->buscarImagenEnTabla('hotel villa leyva'),
                'calificacion' => 4.9,
                'precio' => 185,
                'categoria' => 'Boutique'
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | GASTRONOMÍA
        |--------------------------------------------------------------------------
        */

        $gastronomiaDestacada = PlatoTipico::orderBy('PLATOS_TIPICOS')
            ->take(8)
            ->get()
            ->map(function($plato) {
                return [
                    'id' => $plato->ID_PLATOS,
                    'nombre' => $plato->PLATOS_TIPICOS,
                    'imagen' => $this->buscarImagenEnTabla($plato->PLATOS_TIPICOS),
                    'categoria' => $plato->CATEGORIA ?? 'Plato Típico',
                    'departamento' => $plato->DEPARTAMENTO,
                    'descripcion' => $plato->DESCRIPCION
                ];
            })->toArray();

        /*
        |--------------------------------------------------------------------------
        | EVENTOS
        |--------------------------------------------------------------------------
        */

        $eventosDestacados = FeriaFiesta::orderBy('NOMBRE_FERIAS_Y_FIESTAS')
            ->take(8)
            ->get()
            ->map(function($evento) {
                return [
                    'id' => $evento->ID_FIESTA,
                    'nombre' => $evento->NOMBRE_FERIAS_Y_FIESTAS,
                    'imagen' => $this->buscarImagenEnTabla($evento->NOMBRE_FERIAS_Y_FIESTAS),
                    'fecha' => $evento->FECHA,
                    'ubicacion' => $evento->CIUDAD_DEPARTAMENTO,
                    'descripcion' => $evento->DESCRIPCION
                ];
            })->toArray();


        /*
        |--------------------------------------------------------------------------
        | RETORNO A LA VISTA
        |--------------------------------------------------------------------------
        */

        return compact(
            'stats',
            'destinosPorCategoria',
            'comparacionPorDepartamento',
            'destinosDestacados',
            'explorarTipos',
            'departamentos',
            'municipios',
            'actividades',
            'hotelesDestacados',
            'gastronomiaDestacada',
            'eventosDestacados'
        );
    }

    private function obtenerDestinosDestacados()
    {
        // Destinos destacados fijos con imágenes de tabla_imagenes
        $destinosFijos = [
            [
                'id' => 1,
                'nombre' => 'Cartagena de Indias',
                'categoria' => 'Ciudad Histórica',
                'ubicacion' => 'Bolívar',
                'imagen' => $this->buscarImagenEnTabla('Cartagena'),
                'calificacion' => 4.9,
                'tipo' => 'municipality',
                'url' => '/municipios/bolivar/cartagena'
            ],
            [
                'id' => 2,
                'nombre' => 'Medellín',
                'categoria' => 'Ciudad de la Eterna Primavera',
                'ubicacion' => 'Antioquia',
                'imagen' => $this->buscarImagenEnTabla('Medellin'),
                'calificacion' => 4.8,
                'tipo' => 'municipality',
                'url' => '/municipios/antioquia/medellin'
            ],
            [
                'id' => 3,
                'nombre' => 'Santa Marta',
                'categoria' => 'Destino Caribeño',
                'ubicacion' => 'Magdalena',
                'imagen' => $this->buscarImagenEnTabla('Santa Marta'),
                'calificacion' => 4.7,
                'tipo' => 'municipality',
                'url' => '/municipios/magdalena/santa-marta'
            ],
            [
                'id' => 4,
                'nombre' => 'Eje Cafetero',
                'categoria' => 'Región Cafetera',
                'ubicacion' => 'Andina',
                'imagen' => $this->buscarImagenEnTabla('Armenia'),
                'calificacion' => 4.8,
                'tipo' => 'region',
                'url' => '/departamentos/antioquia'
            ]
        ];

        return $destinosFijos;
    }

    /**
     * Buscar imagen en tabla_imagenes por nombre
     */
    /**
     * Resolver imágenes en lote para evitar N+1 queries
     */
    private function resolveImagenesEnLote(array $nombres)
    {
        if (empty($nombres)) {
            return [];
        }
        
        try {
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')
                    ->select('NOMBRE_IMAGEN', 'RUTA')
                    ->get();
            });
            
            $mapa = [];
            foreach ($nombres as $nombre) {
                if (empty($nombre)) continue;
                $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
                $imagen = $imagenes->first(function($img) use ($nombreNormalizado) {
                    return \App\Helpers\ImageHelper::cleanString($img->NOMBRE_IMAGEN) === $nombreNormalizado;
                });
                $mapa[$nombre] = $imagen ? $imagen->RUTA : null;
            }
            
            return $mapa;
        } catch (\Exception $e) {
            return array_fill_keys($nombres, null);
        }
    }
    
    private function buscarImagenEnTabla($nombre)
    {
        try {
            if (empty($nombre)) {
                return null;
            }

            return ImageResolver::forName($nombre);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function contarModeloSeguro($modelo)
    {
        $cacheKey = 'count_' . class_basename($modelo);

        try {
            return Cache::remember($cacheKey, 3600, function () use ($modelo) {
                return $modelo::count();
            });
        } catch (\Throwable $e) {
            return 0;
        }
    }

    private function obtenerRegistrosSeguro($query)
    {
        try {
            return $query->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    private function formatearDestino($id, $nombre, $categoria, $localityId, $tipo, $calificacion)
    {
        // La tabla tabla_imagenes no tiene locality_id, así que usamos una imagen aleatoria o null
        $imagen = null;
        try {
            // Obtener una imagen aleatoria como placeholder
            $imagen = Imagen::inRandomOrder()->first();
        } catch (\Exception $e) {
            // Si hay error, dejamos imagen como null
        }

        return [
            'id'           => $id,
            'nombre'       => $nombre,
            'categoria'    => $categoria,
            'ubicacion'    => $this->obtenerUbicacion($localityId),
            'imagen'       => $imagen ? $imagen->RUTA : null,
            'calificacion' => $calificacion,
            'tipo'         => $tipo
        ];
    }

    private function obtenerUbicacion($localityId)
    {
        if (!$localityId) {
            return 'Colombia';
        }

        $municipio = Municipio::find($localityId);

        return $municipio->NOMBRE_MUNICIPIOS ?? 'Colombia';
    }
}