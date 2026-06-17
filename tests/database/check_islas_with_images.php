<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ISLAS CON SUS IMÁGENES CORRESPONDIENTES ===\n";

// Obtener islas
$islas = DB::table('tabla_islas')->get();

// Obtener imágenes de islas
$imagenes_islas = DB::table('tabla_imagenes')
    ->where('NOMBRE_IMAGEN', 'like', '%isla%')
    ->orWhere('RUTA', 'like', '%/islas/%')
    ->get();

foreach($islas as $isla) {
    echo "\n--- ISLA: " . $isla->NOMBRE_ISLA . " (ID: " . $isla->ID_ISLA . ") ---\n";
    
    // Buscar imágenes relacionadas
    $imagenes_relacionadas = [];
    foreach($imagenes_islas as $imagen) {
        // Buscar por nombre相似
        if (stripos($imagen->NOMBRE_IMAGEN, $isla->NOMBRE_ISLA) !== false) {
            $imagenes_relacionadas[] = $imagen;
        }
        // Buscar por ruta相似
        elseif (stripos($imagen->RUTA, strtolower(str_replace(' ', '_', $isla->NOMBRE_ISLA))) !== false) {
            $imagenes_relacionadas[] = $imagen;
        }
    }
    
    if (!empty($imagenes_relacionadas)) {
        foreach($imagenes_relacionadas as $img) {
            echo "  Imagen: " . $img->NOMBRE_IMAGEN . " -> " . $img->RUTA . "\n";
        }
    } else {
        echo "  Sin imágenes encontradas\n";
    }
}
