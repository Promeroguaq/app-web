<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BUSCANDO IMAGEN DE YOPAL ===\n";
$imagenes = DB::table('tabla_imagenes')
    ->where('NOMBRE_IMAGEN', 'like', '%Yopal%')
    ->orWhere('RUTA', 'like', '%yopal%')
    ->get();

foreach($imagenes as $img) {
    echo "Encontrado: " . $img->NOMBRE_IMAGEN . " -> " . $img->RUTA . "\n";
}

if($imagenes->count() == 0) {
    echo "No se encontró imagen para Yopal\n";
}

echo "\n=== IMÁGENES DE CAPITALES DISPONIBLES ===\n";
$capitales = DB::table('tabla_imagenes')
    ->where('NOMBRE_IMAGEN', 'like', '%capital%')
    ->orWhere('RUTA', 'like', '%/capital_cities/%')
    ->get();

foreach($capitales as $cap) {
    echo $cap->NOMBRE_IMAGEN . "\n";
}
