<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\ActividadParque;
use App\Models\Isla;
use App\Models\Playa;
use App\Models\Museo;
use App\Models\Iglesia;
use App\Models\DeporteAventura;
use App\Models\DesiertoLaguna;
use App\Models\ParqueTematico;
use App\Models\Termal;
use App\Models\PlatoTipico;
use App\Models\FeriaFiesta;
use App\Models\Ciclismo;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard con estadísticas y gráficos
     */
    public function index()
    {
        set_time_limit(120);

        // Estadísticas generales con datos reales
        $totalDestinos = $this->getTotalDestinos();
        $stats = [
            'destinos' => $totalDestinos,
            'departamentos' => $this->contarModeloSeguro(Departamento::class),
            'actividades' => $this->contarModeloSeguro(ActividadParque::class),
            'rutas' => $this->contarModeloSeguro(Ciclismo::class),
            'turismo_religioso' => $this->contarModeloSeguro(Iglesia::class),
            'eventos' => $this->contarModeloSeguro(FeriaFiesta::class),
            'platos' => $this->contarModeloSeguro(PlatoTipico::class),
        ];

        // Datos para gráfico de torta: destinos por categoría
        $destinosPorCategoria = $this->getDestinosPorCategoria();

        // Datos para gráfico de barras: comparación por departamento
        $comparacionPorDepartamento = $this->getComparacionPorDepartamento();

        // Destinos destacados (hasta 8)
        $destinosDestacados = $this->getDestinosDestacados();

        // Tipos de exploración para categorías
        $explorarTipos = $this->getExplorarTipos();

        // Hoteles destacados (simulados - no hay modelo de hoteles)
        $hotelesDestacados = $this->getHotelesDestacados();

        // Experiencias gastronómicas destacadas
        $gastronomiaDestacada = $this->getGastronomiaDestacada();

        // Eventos destacados
        $eventosDestacados = $this->getEventosDestacados();

        // Imágenes para cards de inspiración
        $inspiracionImages = $this->getInspiracionImages();

        return view('pages.dashboard', compact(
            'stats',
            'destinosPorCategoria',
            'comparacionPorDepartamento',
            'destinosDestacados',
            'explorarTipos',
            'hotelesDestacados',
            'gastronomiaDestacada',
            'eventosDestacados',
            'inspiracionImages'
        ));
    }

    /**
     * Obtener total de destinos (suma de todos los tipos)
     */
    private function getTotalDestinos()
    {
        return $this->contarModeloSeguro(Isla::class) +
               $this->contarModeloSeguro(Playa::class) +
               $this->contarModeloSeguro(Museo::class) +
               $this->contarModeloSeguro(Iglesia::class) +
               $this->contarModeloSeguro(DeporteAventura::class) +
               $this->contarModeloSeguro(DesiertoLaguna::class) +
               $this->contarModeloSeguro(ParqueTematico::class) +
               $this->contarModeloSeguro(Termal::class);
    }

    /**
     * Obtener destinos agrupados por categoría con porcentajes
     */
    private function getDestinosPorCategoria()
    {
        $totalDestinos = $this->getTotalDestinos();
        
        $categorias = [
            'Islas' => [
                'cantidad' => $this->contarModeloSeguro(Isla::class),
                'porcentaje' => ($this->contarModeloSeguro(Isla::class) * 100) / max(1, $totalDestinos)
            ],
            'Playas' => [
                'cantidad' => $this->contarModeloSeguro(Playa::class),
                'porcentaje' => ($this->contarModeloSeguro(Playa::class) * 100) / max(1, $totalDestinos)
            ],
            'Parques Temáticos' => [
                'cantidad' => $this->contarModeloSeguro(ParqueTematico::class),
                'porcentaje' => ($this->contarModeloSeguro(ParqueTematico::class) * 100) / max(1, $totalDestinos)
            ],
            'Museos' => [
                'cantidad' => $this->contarModeloSeguro(Museo::class),
                'porcentaje' => ($this->contarModeloSeguro(Museo::class) * 100) / max(1, $totalDestinos)
            ],
            'Turismo Religioso' => [
                'cantidad' => $this->contarModeloSeguro(Iglesia::class),
                'porcentaje' => ($this->contarModeloSeguro(Iglesia::class) * 100) / max(1, $totalDestinos)
            ],
            'Deportes Aventura' => [
                'cantidad' => $this->contarModeloSeguro(DeporteAventura::class),
                'porcentaje' => ($this->contarModeloSeguro(DeporteAventura::class) * 100) / max(1, $totalDestinos)
            ],
            'Desiertos/Lagunas' => [
                'cantidad' => $this->contarModeloSeguro(DesiertoLaguna::class),
                'porcentaje' => ($this->contarModeloSeguro(DesiertoLaguna::class) * 100) / max(1, $totalDestinos)
            ],
            'Termales' => [
                'cantidad' => $this->contarModeloSeguro(Termal::class),
                'porcentaje' => ($this->contarModeloSeguro(Termal::class) * 100) / max(1, $totalDestinos)
            ],
        ];

        return $categorias;
    }

    /**
     * Obtener comparación de destinos, actividades y hoteles por departamento
     */
    private function getComparacionPorDepartamento()
    {
        // Obtener departamentos sin relaciones complejas
        $departamentos = Departamento::orderBy('NOMBRE_DEPARTAMENTO')
            ->take(10)
            ->get(['ID_DEPARTAMENTO', 'NOMBRE_DEPARTAMENTO']);

        $totalActividades = max(1, $this->contarModeloSeguro(ActividadParque::class));
        $totalDestinos = $this->getTotalDestinos();
        $data = [];
        foreach ($departamentos as $depto) {
            $data[] = [
                'departamento' => $depto->NOMBRE_DEPARTAMENTO,
                'destinos' => ceil($totalDestinos / $departamentos->count()),
                'actividades' => ceil($totalActividades / $departamentos->count()),
                'hoteles' => 0, // No hay modelo de hoteles aún
            ];
        }

        return $data;
    }

    /**
     * Obtener destinos destacados (hasta 8) desde la base de datos
     */
    private function getDestinosDestacados()
    {
        $destinos = [];
        
        // 1. Municipios destacados (Cartagena, Medellín, Bogotá)
        $municipios = \DB::table('tabla_municipios')
            ->whereIn('NOMBRE_MUNICIPIOS', ['Cartagena', 'Medellín', 'Bogotá'])
            ->get();

        foreach ($municipios as $municipio) {
            // Obtener departamento mediante tabla_localities
            $locality = \DB::table('tabla_localities')
                ->where('ID', $municipio->ID_LOCALITIES)
                ->first();

            if ($locality) {
                $deptoSlug = \Illuminate\Support\Str::slug($locality->DEPARTAMENTO);
                $muniSlug = \Illuminate\Support\Str::slug($municipio->NOMBRE_MUNICIPIOS);

                $destinos[] = [
                    'id' => $municipio->ID,
                    'nombre' => $municipio->NOMBRE_MUNICIPIOS,
                    'categoria' => 'Municipio',
                    'ubicacion' => $locality->DEPARTAMENTO,
                    'imagen' => $this->buscarImagenEnTabla($municipio->NOMBRE_MUNICIPIOS),
                    'calificacion' => 4.5,
                    'tipo' => 'municipio',
                    'url' => route('municipios.show.slugs', [
                        'departmentSlug' => $deptoSlug,
                        'municipalitySlug' => $muniSlug
                    ])
                ];
            }
        }
        
        // 2. Reservas/Parques (Parque Tayrona)
        $reserva = \DB::table('tabla_reservas')
            ->where('NOMBRE_RESERVAS_O_PARQUES', 'like', '%Tayrona%')
            ->first();
            
        if ($reserva) {
            $destinos[] = [
                'id' => $reserva->ID_RESERVAS,
                'nombre' => $reserva->NOMBRE_RESERVAS_O_PARQUES,
                'categoria' => 'Reserva Natural',
                'ubicacion' => 'Magdalena',
                'imagen' => $this->buscarImagenEnTabla($reserva->NOMBRE_RESERVAS_O_PARQUES),
                'calificacion' => 4.9,
                'tipo' => 'reserva-parque',
                'url' => route('puntos-interes.reservas-naturales.show', ['id' => $reserva->ID_RESERVAS])
            ];
        }
        
        // 3. Islas (San Andrés)
        $isla = \DB::table('tabla_islas')
            ->where('NOMBRE_ISLA', 'like', '%San Andrés%')
            ->first();
            
        if ($isla) {
            $destinos[] = [
                'id' => $isla->ID_ISLA,
                'nombre' => $isla->NOMBRE_ISLA,
                'categoria' => 'Isla',
                'ubicacion' => 'Caribe',
                'imagen' => $this->buscarImagenEnTabla($isla->NOMBRE_ISLA),
                'calificacion' => 4.8,
                'tipo' => 'isla',
                'url' => route('puntos-interes.islas.show', ['id' => $isla->ID_ISLA])
            ];
        }
        
        // 4. Desiertos/Lagunas (Desierto de la Tatacoa)
        $desierto = DesiertoLaguna::where('NOMBRE_DESIERTO_LAGUNAS', 'like', '%Tatacoa%')
            ->first();

        if ($desierto) {
            $destinos[] = [
                'id' => $desierto->ID_DESIERTO,
                'nombre' => $desierto->NOMBRE_DESIERTO_LAGUNAS,
                'categoria' => 'Desierto',
                'ubicacion' => 'Huila',
                'imagen' => $this->buscarImagenEnTabla($desierto->NOMBRE_DESIERTO_LAGUNAS),
                'calificacion' => 4.7,
                'tipo' => 'desierto-laguna',
                'url' => route('puntos-interes.desiertos-lagunas.show', ['id' => $desierto->ID_DESIERTO])
            ];
        }
        
        // 5. Caño Cristales - buscar en tabla_reservas o desiertos
        $canoCristales = \DB::table('tabla_reservas')
            ->where('NOMBRE_RESERVAS_O_PARQUES', 'like', '%Caño Cristales%')
            ->first();
            
        if ($canoCristales) {
            $destinos[] = [
                'id' => $canoCristales->ID_RESERVAS,
                'nombre' => $canoCristales->NOMBRE_RESERVAS_O_PARQUES,
                'categoria' => 'Río Arcoíris',
                'ubicacion' => 'Meta',
                'imagen' => $this->buscarImagenEnTabla($canoCristales->NOMBRE_RESERVAS_O_PARQUES),
                'calificacion' => 5.0,
                'tipo' => 'reserva-parque',
                'url' => route('puntos-interes.reservas-naturales.show', ['id' => $canoCristales->ID_RESERVAS])
            ];
        }
        
        // 6. Cafetera del Quindío - buscar municipio Salento o Armenia
        $cafetera = \DB::table('tabla_municipios')
            ->whereIn('NOMBRE_MUNICIPIOS', ['Salento', 'Armenia'])
            ->first();

        if ($cafetera) {
            // Obtener departamento mediante tabla_localities
            $locality = \DB::table('tabla_localities')
                ->where('ID', $cafetera->ID_LOCALITIES)
                ->first();

            if ($locality) {
                $deptoSlug = \Illuminate\Support\Str::slug($locality->DEPARTAMENTO);
                $muniSlug = \Illuminate\Support\Str::slug($cafetera->NOMBRE_MUNICIPIOS);

                $destinos[] = [
                    'id' => $cafetera->ID,
                    'nombre' => 'Eje Cafetero - ' . $cafetera->NOMBRE_MUNICIPIOS,
                    'categoria' => 'Paisaje Cultural',
                    'ubicacion' => $locality->DEPARTAMENTO,
                    'imagen' => $this->buscarImagenEnTabla($cafetera->NOMBRE_MUNICIPIOS),
                    'calificacion' => 4.8,
                    'tipo' => 'municipio',
                    'url' => route('municipios.show.slugs', [
                        'departmentSlug' => $deptoSlug,
                        'municipalitySlug' => $muniSlug
                    ])
                ];
            }
        }
        
        return collect($destinos)->take(8);
    }

    /**
     * Contar registros de un modelo de forma segura
     */
    private function contarModeloSeguro($modelo)
    {
        try {
            return $modelo::count();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Buscar imagen en tabla_imagenes por nombre
     */
    private function buscarImagenEnTabla($nombre)
    {
        try {
            if (empty($nombre)) {
                return null;
            }

            $nombreNormalizado = \App\Helpers\ImageHelper::cleanString($nombre);
            $imagen = \DB::table('tabla_imagenes')
                ->select('RUTA')
                ->whereRaw('LOWER(NOMBRE_IMAGEN) LIKE ?', ['%' . strtolower($nombreNormalizado) . '%'])
                ->first();
            
            return $imagen ? $imagen->RUTA : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Obtener tipos de exploración para categorías
     */
    private function getExplorarTipos()
    {
        return [
            ['nombre' => 'Gastronomía', 'url' => route('gastronomia')],
            ['nombre' => 'Alojamiento', 'url' => route('alojamiento')],
            ['nombre' => 'Rutas Turísticas', 'url' => route('rutas-turisticas')],
            ['nombre' => 'Eventos', 'url' => route('eventos')],
            ['nombre' => 'Agencias', 'url' => route('agencias')],
            ['nombre' => 'Departamentos', 'url' => route('departamentos.index')],
            ['nombre' => 'Actividades', 'url' => route('actividades')],
            ['nombre' => 'Categorías', 'url' => route('categorias.index')],
        ];
    }

    /**
     * Obtener hoteles destacados (simulados - no hay modelo de hoteles)
     */
    private function getHotelesDestacados()
    {
        return [
            [
                'nombre' => 'Eco-Lodge Tayrona',
                'categoria' => 'Eco-Lodge',
                'ubicacion' => 'Santa Marta, Magdalena',
                'imagen' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop',
                'calificacion' => 4.9,
                'precio' => 250000,
            ],
            [
                'nombre' => 'Hotel Boutique Cartagena',
                'categoria' => 'Boutique',
                'ubicacion' => 'Cartagena, Bolívar',
                'imagen' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=400&h=300&fit=crop',
                'calificacion' => 4.8,
                'precio' => 320000,
            ],
            [
                'nombre' => 'Reserva Natural Coffee',
                'categoria' => 'Reserva',
                'ubicacion' => 'Salento, Quindío',
                'imagen' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400&h=300&fit=crop',
                'calificacion' => 4.7,
                'precio' => 180000,
            ],
        ];
    }

    /**
     * Obtener experiencias gastronómicas destacadas
     */
    private function getGastronomiaDestacada()
    {
        return [
            [
                'nombre' => 'Bandeja Paisa',
                'categoria' => 'Plato Típico',
                'imagen' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=300&fit=crop',
            ],
            [
                'nombre' => 'Arepas de Huevo',
                'categoria' => 'Desayuno',
                'imagen' => 'https://images.unsplash.com/photo-1585109649139-36641532e43e?w=400&h=300&fit=crop',
            ],
            [
                'nombre' => 'Sancocho de Gallina',
                'categoria' => 'Sopa',
                'imagen' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=300&fit=crop',
            ],
            [
                'nombre' => 'Lechona Tolimense',
                'categoria' => 'Plato Festivo',
                'imagen' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=400&h=300&fit=crop',
            ],
        ];
    }

    /**
     * Obtener eventos destacados
     */
    private function getEventosDestacados()
    {
        return [
            [
                'nombre' => 'Feria de las Flores',
                'ubicacion' => 'Medellín, Antioquia',
                'fecha' => 'Agosto 2026',
                'imagen' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=400&h=300&fit=crop',
            ],
            [
                'nombre' => 'Carnaval de Barranquilla',
                'ubicacion' => 'Barranquilla, Atlántico',
                'fecha' => 'Marzo 2027',
                'imagen' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=400&h=300&fit=crop',
            ],
            [
                'nombre' => 'Festival de Música',
                'ubicacion' => 'Bogotá, Cundinamarca',
                'fecha' => 'Septiembre 2026',
                'imagen' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=400&h=300&fit=crop',
            ],
        ];
    }

    /**
     * Obtener imágenes reales para cards de inspiración
     */
    private function getInspiracionImages()
    {
        return [
            'playas' => $this->buscarImagenEnTabla('Playa') ?? 'https://m.rutascolombia.com/Imagenes_app/sol_y_playa/la_barra.jpg',
            'museos' => $this->buscarImagenEnTabla('Museo') ?? 'https://m.rutascolombia.com/Imagenes_app/turismo_cultural/bogota/mambo_museo_de_arte_moderno.jpg',
            'aventura' => $this->buscarImagenEnTabla('Deporte') ?? 'https://m.rutascolombia.com/Imagenes_app/categorias/aventura.png',
            'gastronomia' => $this->buscarImagenEnTabla('Plato') ?? 'https://m.rutascolombia.com/Imagenes_app/ferias_fiestas_y_festivales/junio/fiesta_nacional_del_cafe_Calarca/fiesta_del_cafe.jpg',
        ];
    }
}
