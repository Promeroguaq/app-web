<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== IMÁGENES DE ISLAS ===\n";
$imagenes = DB::table('tabla_imagenes')->get();
$islas_images = [];

foreach($imagenes as $imagen) {
    if (stripos($imagen->NOMBRE_IMAGEN, 'isla') !== false || stripos($imagen->RUTA, 'isla') !== false) {
        $islas_images[] = $imagen;
        echo "ID: " . $imagen->ID_IMAGEN . ", Nombre: " . $imagen->NOMBRE_IMAGEN . ", Ruta: " . substr($imagen->RUTA, 0, 80) . "...\n";
    }
}

echo "\n=== TOTAL DE IMÁGENES DE ISLAS: " . count($islas_images) . " ===\n";

echo "\n=== IMÁGENES DE PLAYAS (RELACIONADAS CON ISLAS) ===\n";
$playas_images = [];
foreach($imagenes as $imagen) {
    if (stripos($imagen->NOMBRE_IMAGEN, 'playa') !== false || stripos($imagen->RUTA, 'playa') !== false) {
        $playas_images[] = $imagen;
        echo "ID: " . $imagen->ID_IMAGEN . ", Nombre: " . $imagen->NOMBRE_IMAGEN . ", Ruta: " . substr($imagen->RUTA, 0, 80) . "...\n";
    }
}

echo "\n=== TOTAL DE IMÁGENES DE PLAYAS: " . count($playas_images) . " ===\n";
