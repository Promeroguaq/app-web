<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== IMÁGENES DE DEPARTAMENTOS ===\n";
$imagenes = DB::table('tabla_imagenes')->get();
$deptos_images = [];

foreach($imagenes as $imagen) {
    if (stripos($imagen->NOMBRE_IMAGEN, 'capital') !== false || 
        stripos($imagen->RUTA, 'capital_cities') !== false ||
        stripos($imagen->RUTA, 'capital_c') !== false) {
        $deptos_images[] = $imagen;
        echo "ID: " . $imagen->ID_IMAGEN . ", Nombre: " . $imagen->NOMBRE_IMAGEN . ", Ruta: " . substr($imagen->RUTA, 0, 80) . "...\n";
    }
}

echo "\n=== TOTAL DE IMÁGENES DE DEPARTAMENTOS: " . count($deptos_images) . " ===\n";

echo "\n=== DEPARTAMENTOS EN TABLA_DEPARTAMENTOS ===\n";
$departamentos = DB::table('tabla_departamentos')->limit(10)->get();
foreach($departamentos as $depto) {
    echo "ID: " . $depto->ID_DEPARTAMENTO . ", Nombre: " . $depto->NOMBRE_DEPARTAMENTO . "\n";
}
