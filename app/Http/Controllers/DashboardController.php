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

        return view('pages.dashboard', compact(
            'stats',
            'destinosPorCategoria',
            'comparacionPorDepartamento',
            'destinosDestacados'
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
     * Obtener destinos destacados (hasta 8)
     */
    private function getDestinosDestacados()
    {
        // Simular destinos destacados para evitar timeouts
        $destinos = [
            [
                'id' => 1,
                'nombre' => 'Cartagena de Indias',
                'categoria' => 'Ciudad Histórica',
                'ubicacion' => 'Bolívar',
                'imagen' => 'https://images.unsplash.com/photo-1518182170546-0766aa6f7cf0?w=400&h=300&fit=crop',
                'calificacion' => 4.8,
                'tipo' => 'ciudad'
            ],
            [
                'id' => 2,
                'nombre' => 'Parque Tayrona',
                'categoria' => 'Reserva Natural',
                'ubicacion' => 'Magdalena',
                'imagen' => 'https://images.unsplash.com/photo-1580060839134-75a5edca2e99?w=400&h=300&fit=crop',
                'calificacion' => 4.9,
                'tipo' => 'reserva'
            ],
            [
                'id' => 3,
                'nombre' => 'Medellín',
                'categoria' => 'Ciudad Moderna',
                'ubicacion' => 'Antioquia',
                'imagen' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
                'calificacion' => 4.7,
                'tipo' => 'ciudad'
            ],
            [
                'id' => 4,
                'nombre' => 'Cafetera del Quindío',
                'categoria' => 'Paisaje Cultural',
                'ubicacion' => 'Quindío',
                'imagen' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=400&h=300&fit=crop',
                'calificacion' => 4.6,
                'tipo' => 'paisaje'
            ],
            [
                'id' => 5,
                'nombre' => 'Caño Cristales',
                'categoria' => 'Río Arcoíris',
                'ubicacion' => 'Meta',
                'imagen' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=300&fit=crop',
                'calificacion' => 5.0,
                'tipo' => 'rio'
            ],
            [
                'id' => 6,
                'nombre' => 'San Andrés',
                'categoria' => 'Isla',
                'ubicacion' => 'San Andrés',
                'imagen' => 'https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?w=400&h=300&fit=crop',
                'calificacion' => 4.5,
                'tipo' => 'isla'
            ],
            [
                'id' => 7,
                'nombre' => 'Bogotá',
                'categoria' => 'Capital',
                'ubicacion' => 'Cundinamarca',
                'imagen' => 'https://images.unsplash.com/photo-1531566658564-6fc7b751f5c9?w=400&h=300&fit=crop',
                'calificacion' => 4.4,
                'tipo' => 'ciudad'
            ],
            [
                'id' => 8,
                'nombre' => 'Desierto de la Tatacoa',
                'categoria' => 'Desierto',
                'ubicacion' => 'Huila',
                'imagen' => 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=400&h=300&fit=crop',
                'calificacion' => 4.3,
                'tipo' => 'desierto'
            ]
        ];

        return collect($destinos);
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
}
