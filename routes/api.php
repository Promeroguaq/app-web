<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CapitalController;
use App\Http\Controllers\API\DepartamentoController;
use App\Http\Controllers\API\MunicipioController;
use App\Http\Controllers\API\IslaController;
use App\Http\Controllers\API\LocalityController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\DeporteAventuraController;
use App\Http\Controllers\API\DesiertoLagunaController;
use App\Http\Controllers\API\FeriaFiestaController;
use App\Http\Controllers\API\IglesiaController;
use App\Http\Controllers\API\ParqueTematicoController;
use App\Http\Controllers\API\PlayaController;
use App\Http\Controllers\API\PlatoTipicoController;
use App\Http\Controllers\API\MuseoController;
use App\Http\Controllers\API\TermalController;
use App\Http\Controllers\API\ReservaParqueController;
use App\Http\Controllers\API\ActividadParqueController;
use App\Http\Controllers\API\ImagenController;
use App\Http\Controllers\API\RutaCiclismoController;
use App\Http\Controllers\API\CategoriaGastronomicaController;
use App\Http\Controllers\API\AgenciaController;

// Capitales
Route::apiResource('capitales', CapitalController::class);

// Departamentos
Route::apiResource('departamentos', DepartamentoController::class);

// Municipios
Route::apiResource('municipios', MunicipioController::class);

// Islas
Route::apiResource('islas', IslaController::class);

// Localidades
Route::apiResource('localities', LocalityController::class);

// Regiones
Route::apiResource('regions', RegionController::class);

// Turismo
Route::apiResource('deportes-aventura', DeporteAventuraController::class);
Route::apiResource('desiertos-lagunas', DesiertoLagunaController::class);
Route::apiResource('ferias-fiestas', FeriaFiestaController::class);
Route::apiResource('iglesias', IglesiaController::class);
Route::apiResource('parques-tematicos', ParqueTematicoController::class);
Route::apiResource('playas', PlayaController::class);
Route::apiResource('platos-tipicos', PlatoTipicoController::class);
Route::apiResource('museos', MuseoController::class);
Route::apiResource('termales', TermalController::class);
Route::apiResource('reservas-parques', ReservaParqueController::class);
Route::apiResource('actividades-parques', ActividadParqueController::class);
Route::apiResource('imagenes', ImagenController::class);
Route::apiResource('rutas-ciclismo', RutaCiclismoController::class);
Route::apiResource('categorias-gastronomicas', CategoriaGastronomicaController::class);
Route::apiResource('agencias', AgenciaController::class);
