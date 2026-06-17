<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PuntoInteresController;
use App\Http\Controllers\GastronomiaController;
use App\Http\Controllers\AlojamientoController;
use App\Http\Controllers\RutasTuristicasController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DestinosController;
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
*/


// Rutas principales (home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Ruta para dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta para categorías
Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');

// Rutas para Destinos (usando MunicipioController para mostrar municipios)
Route::get('/destinos', [MunicipioController::class, 'index'])->name('destinos');
Route::get('/destinos/{id}', [MunicipioController::class, 'show'])->name('destinos.show');

// Rutas para Actividades
Route::get('/actividades', [ActividadesController::class, 'index'])->name('actividades');

// Rutas para Gastronomía
Route::get('/gastronomia', [GastronomiaController::class, 'index'])->name('gastronomia');
Route::get('/gastronomia/{departmentSlug}/{platoSlug}', [GastronomiaController::class, 'show'])->name('gastronomia.show');

// Rutas para Eventos
Route::get('/eventos', [EventosController::class, 'index'])->name('eventos');
Route::get('/eventos/{slug}', [EventosController::class, 'show'])->name('eventos.show');

// Rutas para Fiestas y Ferias
Route::get('/fiestas-y-ferias', [FeriaController::class, 'index'])->name('fiestas-ferias.index');
Route::get('/fiestas-y-ferias/{id}', [FeriaController::class, 'show'])->name('fiestas-ferias.show');

// Rutas para Capitales
Route::get('/capitales', [CapitalController::class, 'index'])->name('capitales.index');
Route::get('/capitales/{slug}', [CapitalController::class, 'show'])->name('capitales.show');

// Rutas para Regiones Naturales
Route::get('/regiones', [NaturalRegionsController::class, 'index'])->name('regiones');
Route::get('/regiones/{slug}', [NaturalRegionsController::class, 'show'])->name('regiones.show');

// Rutas para Alojamiento
Route::get('/alojamiento', [AlojamientoController::class, 'index'])->name('alojamiento');
Route::get('/alojamiento/casas-de-huespedes', [AlojamientoController::class, 'casasDeHuespedes'])->name('alojamiento.casas-de-huespedes');
Route::get('/alojamiento/eco-lodges', [AlojamientoController::class, 'ecoLodges'])->name('alojamiento.eco-lodges');
Route::get('/alojamiento/resorts', [AlojamientoController::class, 'resorts'])->name('alojamiento.resorts');

// Rutas para Rutas Turísticas
Route::get('/rutas-turisticas', [RutasTuristicasController::class, 'index'])->name('rutas-turisticas');

// Rutas para Agencias de Viaje
Route::get('/agencias', function () {
    return view('pages.agencias');
})->name('agencias');

// Rutas para Configuración
Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion');
Route::post('/configuracion/general', [ConfiguracionController::class, 'updateGeneral'])->name('configuracion.update.general');
Route::post('/configuracion/notificaciones', [ConfiguracionController::class, 'updateNotificaciones'])->name('configuracion.update.notificaciones');
Route::post('/configuracion/privacidad', [ConfiguracionController::class, 'updatePrivacidad'])->name('configuracion.update.privacidad');

// Rutas para Puntos de Interés
Route::prefix('puntos-interes')->name('puntos-interes.')->group(function () {
    Route::get('/deportes-aventura', [PuntoInteresController::class, 'deportesAventura'])->name('deportes-aventura');
    Route::get('/deportes-aventura/{slug}', [PuntoInteresController::class, 'deportesAventuraShow'])->name('deportes-aventura.show');
    Route::get('/desiertos-lagunas', [PuntoInteresController::class, 'desiertosLagunas'])->name('desiertos-lagunas');
    Route::get('/desiertos-lagunas/{id}', [PuntoInteresController::class, 'desiertosLagunasShow'])->name('desiertos-lagunas.show');
    Route::get('/iglesias', [PuntoInteresController::class, 'iglesias'])->name('iglesias');
    Route::get('/iglesias/{id}', [PuntoInteresController::class, 'iglesiasShow'])->name('iglesias.show');
    Route::get('/islas', [PuntoInteresController::class, 'islas'])->name('islas');
    Route::get('/museos', [PuntoInteresController::class, 'museos'])->name('museos');
    Route::get('/museos/{id}', [PuntoInteresController::class, 'museosShow'])->name('museos.show');
    Route::get('/parques-tematicos', [PuntoInteresController::class, 'parquesTematicos'])->name('parques-tematicos');
    Route::get('/parques-tematicos/{id}', [PuntoInteresController::class, 'parquesTematicosShow'])->name('parques-tematicos.show');
    Route::get('/playas', [PuntoInteresController::class, 'playas'])->name('playas');
    Route::get('/playas/{id}', [PuntoInteresController::class, 'playasShow'])->name('playas.show');
    Route::get('/reservas-naturales', [PuntoInteresController::class, 'reservasNaturales'])->name('reservas-naturales');
    Route::get('/reservas-naturales/{id}', [PuntoInteresController::class, 'reservasNaturalesShow'])->name('reservas-naturales.show');
    Route::get('/termales', [PuntoInteresController::class, 'termales'])->name('termales');
    Route::get('/termales/{id}', [PuntoInteresController::class, 'termalesShow'])->name('termales.show');
    Route::get('/regiones', [PuntoInteresController::class, 'regiones'])->name('regiones');
    Route::get('/ciclismo', [PuntoInteresController::class, 'ciclismo'])->name('ciclismo');
    Route::get('/ciclismo/{slug}', [PuntoInteresController::class, 'showCiclismo'])->name('ciclismo.show');
    Route::get('/fiestas-ferias', [PuntoInteresController::class, 'fiestasFerias'])->name('fiestas-ferias');
    Route::get('/actividades-parques', [PuntoInteresController::class, 'actividadesParques'])->name('actividades-parques');
    Route::get('/actividades-parques/{id}', [PuntoInteresController::class, 'actividadesParquesShow'])->name('actividades-parques.show');
});

// Rutas para Reservas y Parques Naturales
Route::get('/reservas-parques', [ReservaParqueController::class, 'index'])->name('reservas-parques.index');
Route::get('/reservas-parques/{slug}', [ReservaParqueController::class, 'show'])->name('reservas-parques.show');

// Rutas completas para departamentos (CRUD y adicionales)
Route::prefix('departamentos')->name('departamentos.')->group(function () {
    // Listado y búsquedas
    Route::get('/', [DepartamentoController::class, 'index'])->name('index');
    Route::get('/activos', [DepartamentoController::class, 'activos'])->name('activos');
    Route::get('/buscar', [DepartamentoController::class, 'buscar'])->name('buscar');

    // Creación
    Route::get('/crear', [DepartamentoController::class, 'create'])->name('create');
    Route::post('/', [DepartamentoController::class, 'store'])->name('store');

    // Edición y actualización
    Route::get('/{id}/editar', [DepartamentoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DepartamentoController::class, 'update'])->name('update');

    // Eliminación
    Route::delete('/{id}', [DepartamentoController::class, 'destroy'])->name('destroy');

    // Ver detalle por slug (debe ir antes de /{id} para evitar conflicto)
    Route::get('/{slug}', [DepartamentoController::class, 'showBySlug'])->name('show.slug');

    // Ver detalle individual por ID (debe ir al final para no interferir con /crear, /activos, etc.)
    Route::get('/{id}', [DepartamentoController::class, 'show'])->name('show');
});

// Rutas para municipios
Route::prefix('municipios')->name('municipios.')->group(function () {
    // Listado
    Route::get('/', [MunicipioController::class, 'index'])->name('index');

    // Municipios de un departamento específico (debe ir antes de /{id})
    Route::get('/departamento/{departamento_id}', [MunicipioController::class, 'porDepartamento'])->name('por-departamento');

    // Ver detalle por slugs (debe ir antes de /{id})
    Route::get('/{departmentSlug}/{municipalitySlug}', [MunicipioController::class, 'showBySlugs'])->name('show.slugs');

    // Ver detalle individual por ID
    Route::get('/{id}', [MunicipioController::class, 'show'])->name('show');
});

// Rutas para detalle de categorías con slugs (reutilizable para departamentos y municipios)
Route::prefix('departamentos')->name('departamentos.')->group(function () {
    Route::get('/{departmentSlug}/categorias/{categorySlug}', [CategoryDetailController::class, 'showDepartmentCategoryBySlug'])->name('categoria.slug');
});

Route::prefix('municipios')->name('municipios.')->group(function () {
    Route::get('/{departmentSlug}/{municipalitySlug}/categorias/{categorySlug}', [CategoryDetailController::class, 'showMunicipalityCategoryBySlug'])->name('categoria.slug');
});

// Rutas para reviews
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');