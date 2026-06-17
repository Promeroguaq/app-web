<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Capital;
use App\Models\Region;
use App\Models\Isla;
use App\Models\Locality;
use App\Models\DeporteAventura;
use App\Models\Ciclismo;
use App\Models\Termal;
use App\Models\Playa;
use App\Models\ReservaParque;
use App\Models\ActividadParque;
use App\Models\Museo;
use App\Models\Iglesia;
use App\Models\ParqueTematico;
use App\Models\DesiertoLaguna;
use App\Models\PlatoTipico;
use App\Models\CategoriaGastronomica;
use App\Models\FeriaFiesta;

class CategoriasController extends Controller
{
    /**
     * Mostrar página principal de categorías
     */
    public function index()
    {
        // Obtener conteos reales para cada categoría
        $categorias = [
            [
                'nombre' => 'Departamentos',
                'descripcion' => 'Divisiones administrativas principales de Colombia',
                'icono' => 'fas fa-map',
                'color' => 'primary',
                'count' => $this->contarModeloSeguro(Departamento::class),
                'tipo' => 'geografica',
                'ruta' => route('departamentos.index')
            ],
            [
                'nombre' => 'Municipios',
                'descripcion' => 'Ciudades y municipios colombianos',
                'icono' => 'fas fa-city',
                'color' => 'info',
                'count' => $this->contarModeloSeguro(Municipio::class),
                'tipo' => 'geografica',
                'ruta' => route('destinos')
            ],
            [
                'nombre' => 'Capitales',
                'descripcion' => 'Capitales departamentales de Colombia',
                'icono' => 'fas fa-landmark',
                'color' => 'warning',
                'count' => $this->contarModeloSeguro(Capital::class),
                'tipo' => 'geografica',
                'ruta' => route('capitales.index')
            ],
            [
                'nombre' => 'Regiones',
                'descripcion' => 'Regiones geográficas de Colombia',
                'icono' => 'fas fa-globe-americas',
                'color' => 'success',
                'count' => 6, // 6 regiones naturales: Caribe, Andina, Pacífica, Amazonía, Llanos, Insular
                'tipo' => 'geografica',
                'ruta' => route('regiones')
            ],
            [
                'nombre' => 'Islas',
                'descripcion' => 'Islas colombianas y territorios insulares',
                'icono' => 'fas fa-island-tropical',
                'color' => 'danger',
                'count' => $this->contarModeloSeguro(Isla::class),
                'tipo' => 'naturaleza',
                'ruta' => route('puntos-interes.islas')
            ],
            [
                'nombre' => 'Deportes de aventura',
                'descripcion' => 'Actividades extremas y deportes al aire libre',
                'icono' => 'fas fa-hiking',
                'color' => 'success',
                'count' => $this->contarModeloSeguro(DeporteAventura::class),
                'tipo' => 'turismo',
                'ruta' => route('puntos-interes.deportes-aventura')
            ],
            [
                'nombre' => 'Ciclismo',
                'descripcion' => 'Rutas ciclistas y destinos para bicicleta',
                'icono' => 'fas fa-bicycle',
                'color' => 'info',
                'count' => $this->contarModeloSeguro(Ciclismo::class),
                'tipo' => 'turismo',
                'ruta' => route('puntos-interes.ciclismo')
            ],
            [
                'nombre' => 'Termales',
                'descripcion' => 'Aguas termales y baños saludables',
                'icono' => 'fas fa-hot-tub',
                'color' => 'warning',
                'count' => $this->contarModeloSeguro(Termal::class),
                'tipo' => 'naturaleza',
                'ruta' => route('puntos-interes.termales')
            ],
            [
                'nombre' => 'Playas',
                'descripcion' => 'Playas y destinos costeros',
                'icono' => 'fas fa-umbrella-beach',
                'color' => 'primary',
                'count' => $this->contarModeloSeguro(Playa::class),
                'tipo' => 'naturaleza',
                'ruta' => route('puntos-interes.playas')
            ],
            [
                'nombre' => 'Reservas de parques',
                'descripcion' => 'Áreas protegidas y reservas naturales',
                'icono' => 'fas fa-tree',
                'color' => 'success',
                'count' => $this->contarReservasUnicas(),
                'tipo' => 'naturaleza',
                'ruta' => route('reservas-parques.index')
            ],
            [
                'nombre' => 'Actividades de parques',
                'descripcion' => 'Actividades recreativas en parques',
                'icono' => 'fas fa-campground',
                'color' => 'info',
                'count' => $this->contarModeloSeguro(ActividadParque::class),
                'tipo' => 'turismo',
                'ruta' => route('puntos-interes.actividades-parques')
            ],
            [
                'nombre' => 'Museos',
                'descripcion' => 'Museos y centros culturales',
                'icono' => 'fas fa-museum',
                'color' => 'purple',
                'count' => $this->contarModeloSeguro(Museo::class),
                'tipo' => 'cultural',
                'ruta' => route('puntos-interes.museos')
            ],
            [
                'nombre' => 'Iglesias',
                'descripcion' => 'Templos y sitios de turismo religioso',
                'icono' => 'fas fa-church',
                'color' => 'indigo',
                'count' => $this->contarModeloSeguro(Iglesia::class),
                'tipo' => 'cultural',
                'ruta' => route('puntos-interes.iglesias')
            ],
            [
                'nombre' => 'Parques temáticos',
                'descripcion' => 'Parques de diversiones y entretenimiento',
                'icono' => 'fas fa-roller-coaster',
                'color' => 'danger',
                'count' => $this->contarModeloSeguro(ParqueTematico::class),
                'tipo' => 'turismo',
                'ruta' => route('puntos-interes.parques-tematicos')
            ],
            [
                'nombre' => 'Fiestas y ferias',
                'descripcion' => 'Eventos culturales y celebraciones tradicionales',
                'icono' => 'fas fa-calendar-alt',
                'color' => 'warning',
                'count' => $this->contarModeloSeguro(FeriaFiesta::class),
                'tipo' => 'cultural',
                'ruta' => route('fiestas-ferias.index')
            ],
            [
                'nombre' => 'Desiertos y lagunas',
                'descripcion' => 'Desiertos y cuerpos de agua especiales',
                'icono' => 'fas fa-water',
                'color' => 'info',
                'count' => $this->contarModeloSeguro(DesiertoLaguna::class),
                'tipo' => 'naturaleza',
                'ruta' => route('puntos-interes.desiertos-lagunas')
            ],
            [
                'nombre' => 'Gastronomía',
                'descripcion' => 'Platos, bebidas, postres y sabores tradicionales de Colombia.',
                'icono' => 'fas fa-utensils',
                'color' => 'success',
                'count' => $this->contarPlatosUnicos(),
                'tipo' => 'gastronomia',
                'ruta' => route('gastronomia')
            ],
            [
                'nombre' => 'Agencias',
                'descripcion' => 'Agencias de viajes y turismo',
                'icono' => 'fas fa-building',
                'color' => 'secondary',
                'count' => 0, // No hay tabla aún
                'tipo' => 'servicios',
                'ruta' => '#'
            ]
        ];

        // Agrupar por tipo para filtros
        $categoriasPorTipo = [
            'Todas' => $categorias,
            'Geográficas' => array_filter($categorias, fn($cat) => $cat['tipo'] === 'geografica'),
            'Turismo' => array_filter($categorias, fn($cat) => $cat['tipo'] === 'turismo'),
            'Cultural' => array_filter($categorias, fn($cat) => $cat['tipo'] === 'cultural'),
            'Naturaleza' => array_filter($categorias, fn($cat) => $cat['tipo'] === 'naturaleza'),
            'Gastronomía' => array_filter($categorias, fn($cat) => $cat['tipo'] === 'gastronomia'),
            'Servicios' => array_filter($categorias, fn($cat) => $cat['tipo'] === 'servicios')
        ];

        return view('pages.categorias', compact('categorias', 'categoriasPorTipo'));
    }

    /**
     * Contar registros de un modelo de forma segura con cache
     */
    private function contarModeloSeguro($modelo)
    {
        $cacheKey = 'count_' . class_basename($modelo);
        
        try {
            return Cache::remember($cacheKey, 1800, function () use ($modelo) {
                return $modelo::count();
            });
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Contar platos únicos de tabla_gastronomia con cache
     */
    private function contarPlatosUnicos()
    {
        try {
            return Cache::remember('count_platos_unicos', 1800, function () {
                return \DB::table('tabla_gastronomia')
                    ->whereNotNull('PLATOS_TIPICOS')
                    ->where('PLATOS_TIPICOS', '!=', 'PLATOS_TIPICOS')
                    ->distinct()
                    ->count('ID_PLATOS');
            });
        } catch (\Throwable $e) {
            \Log::error('Error contando platos únicos: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Contar reservas únicas de tabla_reservas con cache
     */
    private function contarReservasUnicas()
    {
        try {
            return Cache::remember('count_reservas_unicas', 1800, function () {
                return \DB::table('tabla_reservas')
                    ->whereNotNull('NOMBRE_RESERVAS_O_PARQUES')
                    ->where('NOMBRE_RESERVAS_O_PARQUES', '!=', 'NOMBRE_RESERVAS_O_PARQUES')
                    ->distinct()
                    ->count('ID_RESERVAS');
            });
        } catch (\Throwable $e) {
            \Log::error('Error contando reservas únicos: ' . $e->getMessage());
            return 0;
        }
    }
}
