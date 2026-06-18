<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PuntoInteresController;
use App\Http\Controllers\GastronomiaController;
use App\Http\Controllers\AlojamientoController;
use App\Http\Controllers\RutasTuristicasController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CategoryDetailController;
use App\Http\Controllers\NaturalRegionsController;
use App\Http\Controllers\CapitalController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReservaParqueController;
use App\Http\Controllers\FeriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| El Dashboard es la página principal de la aplicación.
| La URL raíz "/" redirige automáticamente a "/dashboard".
|
*/

/*
|--------------------------------------------------------------------------
| Inicio / Dashboard
|--------------------------------------------------------------------------
*/

// Página principal real.
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// La raíz pública redirige al Dashboard.
// Se conserva el nombre "home" por compatibilidad con enlaces antiguos.
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

/*
|--------------------------------------------------------------------------
| Categorías
|--------------------------------------------------------------------------
*/

Route::get('/categorias', [CategoriasController::class, 'index'])
    ->name('categorias.index');

/*
|--------------------------------------------------------------------------
| Destinos
|--------------------------------------------------------------------------
*/

Route::get('/destinos', [MunicipioController::class, 'index'])
    ->name('destinos');

Route::get('/destinos/{id}', [MunicipioController::class, 'show'])
    ->whereNumber('id')
    ->name('destinos.show');

/*
|--------------------------------------------------------------------------
| Actividades
|--------------------------------------------------------------------------
*/

Route::get('/actividades', [ActividadesController::class, 'index'])
    ->name('actividades');

/*
|--------------------------------------------------------------------------
| Gastronomía
|--------------------------------------------------------------------------
*/

Route::get('/gastronomia', [GastronomiaController::class, 'index'])
    ->name('gastronomia');

// Debe ir después de la ruta principal de gastronomía.
Route::get(
    '/gastronomia/{departmentSlug}/{platoSlug}',
    [GastronomiaController::class, 'show']
)
    ->where([
        'departmentSlug' => '[A-Za-z0-9\-]+',
        'platoSlug' => '[A-Za-z0-9\-]+',
    ])
    ->name('gastronomia.show');

/*
|--------------------------------------------------------------------------
| Eventos
|--------------------------------------------------------------------------
*/

Route::get('/eventos', [EventosController::class, 'index'])
    ->name('eventos');

Route::get('/eventos/{slug}', [EventosController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('eventos.show');

/*
|--------------------------------------------------------------------------
| Fiestas y Ferias
|--------------------------------------------------------------------------
*/

Route::get('/fiestas-y-ferias', [FeriaController::class, 'index'])
    ->name('fiestas-ferias.index');

Route::get('/fiestas-y-ferias/{id}', [FeriaController::class, 'show'])
    ->whereNumber('id')
    ->name('fiestas-ferias.show');

/*
|--------------------------------------------------------------------------
| Capitales
|--------------------------------------------------------------------------
*/

Route::get('/capitales', [CapitalController::class, 'index'])
    ->name('capitales.index');

Route::get('/capitales/{slug}', [CapitalController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('capitales.show');

/*
|--------------------------------------------------------------------------
| Regiones Naturales
|--------------------------------------------------------------------------
*/

Route::get('/regiones', [NaturalRegionsController::class, 'index'])
    ->name('regiones');

Route::get('/regiones/{slug}', [NaturalRegionsController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('regiones.show');

/*
|--------------------------------------------------------------------------
| Alojamiento
|--------------------------------------------------------------------------
*/

Route::get('/alojamiento', [AlojamientoController::class, 'index'])
    ->name('alojamiento');

Route::get(
    '/alojamiento/casas-de-huespedes',
    [AlojamientoController::class, 'casasDeHuespedes']
)->name('alojamiento.casas-de-huespedes');

Route::get(
    '/alojamiento/eco-lodges',
    [AlojamientoController::class, 'ecoLodges']
)->name('alojamiento.eco-lodges');

Route::get(
    '/alojamiento/resorts',
    [AlojamientoController::class, 'resorts']
)->name('alojamiento.resorts');

/*
|--------------------------------------------------------------------------
| Rutas Turísticas
|--------------------------------------------------------------------------
*/

Route::get('/rutas-turisticas', [RutasTuristicasController::class, 'index'])
    ->name('rutas-turisticas');

/*
|--------------------------------------------------------------------------
| Agencias
|--------------------------------------------------------------------------
*/

Route::view('/agencias', 'pages.agencias')
    ->name('agencias');

/*
|--------------------------------------------------------------------------
| Configuración
|--------------------------------------------------------------------------
*/

Route::get('/configuracion', [ConfiguracionController::class, 'index'])
    ->name('configuracion');

Route::post(
    '/configuracion/general',
    [ConfiguracionController::class, 'updateGeneral']
)->name('configuracion.update.general');

Route::post(
    '/configuracion/notificaciones',
    [ConfiguracionController::class, 'updateNotificaciones']
)->name('configuracion.update.notificaciones');

Route::post(
    '/configuracion/privacidad',
    [ConfiguracionController::class, 'updatePrivacidad']
)->name('configuracion.update.privacidad');

/*
|--------------------------------------------------------------------------
| Puntos de Interés
|--------------------------------------------------------------------------
*/

Route::prefix('puntos-interes')
    ->name('puntos-interes.')
    ->group(function () {
        // Deportes de aventura.
        Route::get(
            '/deportes-aventura',
            [PuntoInteresController::class, 'deportesAventura']
        )->name('deportes-aventura');

        Route::get(
            '/deportes-aventura/{slug}',
            [PuntoInteresController::class, 'deportesAventuraShow']
        )
            ->where('slug', '[A-Za-z0-9\-]+')
            ->name('deportes-aventura.show');

        // Desiertos y lagunas.
        Route::get(
            '/desiertos-lagunas',
            [PuntoInteresController::class, 'desiertosLagunas']
        )->name('desiertos-lagunas');

        Route::get(
            '/desiertos-lagunas/{id}',
            [PuntoInteresController::class, 'desiertosLagunasShow']
        )
            ->whereNumber('id')
            ->name('desiertos-lagunas.show');

        // Iglesias.
        Route::get(
            '/iglesias',
            [PuntoInteresController::class, 'iglesias']
        )->name('iglesias');

        Route::get(
            '/iglesias/{id}',
            [PuntoInteresController::class, 'iglesiasShow']
        )
            ->whereNumber('id')
            ->name('iglesias.show');

        // Islas.
        Route::get(
            '/islas',
            [PuntoInteresController::class, 'islas']
        )->name('islas');

        Route::get(
            '/islas/{id}',
            [PuntoInteresController::class, 'islasShow']
        )
            ->whereNumber('id')
            ->name('islas.show');

        // Museos.
        Route::get(
            '/museos',
            [PuntoInteresController::class, 'museos']
        )->name('museos');

        Route::get(
            '/museos/{id}',
            [PuntoInteresController::class, 'museosShow']
        )
            ->whereNumber('id')
            ->name('museos.show');

        // Parques temáticos.
        Route::get(
            '/parques-tematicos',
            [PuntoInteresController::class, 'parquesTematicos']
        )->name('parques-tematicos');

        Route::get(
            '/parques-tematicos/{id}',
            [PuntoInteresController::class, 'parquesTematicosShow']
        )
            ->whereNumber('id')
            ->name('parques-tematicos.show');

        // Playas.
        Route::get(
            '/playas',
            [PuntoInteresController::class, 'playas']
        )->name('playas');

        Route::get(
            '/playas/{id}',
            [PuntoInteresController::class, 'playasShow']
        )
            ->whereNumber('id')
            ->name('playas.show');

        // Reservas naturales.
        Route::get(
            '/reservas-naturales',
            [PuntoInteresController::class, 'reservasNaturales']
        )->name('reservas-naturales');

        Route::get(
            '/reservas-naturales/{id}',
            [PuntoInteresController::class, 'reservasNaturalesShow']
        )
            ->whereNumber('id')
            ->name('reservas-naturales.show');

        // Termales.
        Route::get(
            '/termales',
            [PuntoInteresController::class, 'termales']
        )->name('termales');

        Route::get(
            '/termales/{id}',
            [PuntoInteresController::class, 'termalesShow']
        )
            ->whereNumber('id')
            ->name('termales.show');

        // Regiones dentro de puntos de interés.
        Route::get(
            '/regiones',
            [PuntoInteresController::class, 'regiones']
        )->name('regiones');

        // Ciclismo.
        Route::get(
            '/ciclismo',
            [PuntoInteresController::class, 'ciclismo']
        )->name('ciclismo');

        Route::get(
            '/ciclismo/{slug}',
            [PuntoInteresController::class, 'showCiclismo']
        )
            ->where('slug', '[A-Za-z0-9\-]+')
            ->name('ciclismo.show');

        // Fiestas y ferias dentro de puntos de interés.
        Route::get(
            '/fiestas-ferias',
            [PuntoInteresController::class, 'fiestasFerias']
        )->name('fiestas-ferias');

        // Actividades en parques.
        Route::get(
            '/actividades-parques',
            [PuntoInteresController::class, 'actividadesParques']
        )->name('actividades-parques');

        Route::get(
            '/actividades-parques/{id}',
            [PuntoInteresController::class, 'actividadesParquesShow']
        )
            ->whereNumber('id')
            ->name('actividades-parques.show');
    });

/*
|--------------------------------------------------------------------------
| Reservas y Parques Naturales
|--------------------------------------------------------------------------
*/

Route::get(
    '/reservas-parques',
    [ReservaParqueController::class, 'index']
)->name('reservas-parques.index');

Route::get(
    '/reservas-parques/{id}',
    [ReservaParqueController::class, 'show']
)
    ->whereNumber('id')
    ->name('reservas-parques.show');

/*
|--------------------------------------------------------------------------
| Departamentos
|--------------------------------------------------------------------------
*/

Route::prefix('departamentos')
    ->name('departamentos.')
    ->group(function () {
        // Listado.
        Route::get('/', [DepartamentoController::class, 'index'])
            ->name('index');

        // Rutas específicas: deben ir antes de las rutas dinámicas.
        Route::get('/activos', [DepartamentoController::class, 'activos'])
            ->name('activos');

        Route::get('/buscar', [DepartamentoController::class, 'buscar'])
            ->name('buscar');

        Route::get('/crear', [DepartamentoController::class, 'create'])
            ->name('create');

        Route::post('/', [DepartamentoController::class, 'store'])
            ->name('store');

        // Categoría dentro de un departamento.
        Route::get(
            '/{departmentSlug}/categorias/{categorySlug}',
            [CategoryDetailController::class, 'showDepartmentCategoryBySlug']
        )
            ->where([
                'departmentSlug' => '[A-Za-z0-9\-]+',
                'categorySlug' => '[A-Za-z0-9\-]+',
            ])
            ->name('categoria.slug');

        // Edición por ID.
        Route::get(
            '/{id}/editar',
            [DepartamentoController::class, 'edit']
        )
            ->whereNumber('id')
            ->name('edit');

        Route::put(
            '/{id}',
            [DepartamentoController::class, 'update']
        )
            ->whereNumber('id')
            ->name('update');

        Route::delete(
            '/{id}',
            [DepartamentoController::class, 'destroy']
        )
            ->whereNumber('id')
            ->name('destroy');

        /*
         * Detalle por ID.
         *
         * La restricción whereNumber evita el conflicto con la ruta por slug.
         */
        Route::get(
            '/{id}',
            [DepartamentoController::class, 'show']
        )
            ->whereNumber('id')
            ->name('show');

        /*
         * Detalle por slug.
         *
         * Debe quedar después de las rutas específicas y de la ruta numérica.
         */
        Route::get(
            '/{slug}',
            [DepartamentoController::class, 'showBySlug']
        )
            ->where('slug', '[A-Za-z][A-Za-z0-9\-]*')
            ->name('show.slug');
    });

/*
|--------------------------------------------------------------------------
| Municipios
|--------------------------------------------------------------------------
*/

Route::prefix('municipios')
    ->name('municipios.')
    ->group(function () {
        // Listado.
        Route::get('/', [MunicipioController::class, 'index'])
            ->name('index');

        // Municipios pertenecientes a un departamento.
        Route::get(
            '/departamento/{departamento_id}',
            [MunicipioController::class, 'porDepartamento']
        )
            ->whereNumber('departamento_id')
            ->name('por-departamento');

        // Categoría dentro de un municipio.
        Route::get(
            '/{departmentSlug}/{municipalitySlug}/categorias/{categorySlug}',
            [CategoryDetailController::class, 'showMunicipalityCategoryBySlug']
        )
            ->where([
                'departmentSlug' => '[A-Za-z0-9\-]+',
                'municipalitySlug' => '[A-Za-z0-9\-]+',
                'categorySlug' => '[A-Za-z0-9\-]+',
            ])
            ->name('categoria.slug');

        // Detalle por departamento y municipio.
        Route::get(
            '/{departmentSlug}/{municipalitySlug}',
            [MunicipioController::class, 'showBySlugs']
        )
            ->where([
                'departmentSlug' => '[A-Za-z0-9\-]+',
                'municipalitySlug' => '[A-Za-z0-9\-]+',
            ])
            ->name('show.slugs');

        // Detalle antiguo por ID.
        Route::get(
            '/{id}',
            [MunicipioController::class, 'show']
        )
            ->whereNumber('id')
            ->name('show');
    });

/*
|--------------------------------------------------------------------------
| Reviews
|--------------------------------------------------------------------------
*/

Route::post('/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');

