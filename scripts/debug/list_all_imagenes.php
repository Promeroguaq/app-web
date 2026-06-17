<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TODAS LAS IMÁGENES EN tabla_imagenes ===\n\n";
$imagenes = DB::table('tabla_imagenes')->get();
echo "Total: " . count($imagenes) . " imágenes\n\n";

foreach($imagenes as $img) {
    echo "ID: " . $img->ID_IMAGEN . "\n";
    echo "Nombre: " . $img->NOMBRE_IMAGEN . "\n";
    echo "Ruta: " . $img->RUTA . "\n";
    echo "---\n";
}
