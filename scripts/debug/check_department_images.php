<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking department images in tabla_imagenes...\n\n";

$images = DB::table('tabla_imagenes')
    ->whereIn('NOMBRE_IMAGEN', ['Antioquia', 'Cundinamarca', 'Boyaca', 'Caldas', 'Risaralda', 'Quindio', 'Santander', 'Tolima', 'Huila', 'Narino'])
    ->get(['NOMBRE_IMAGEN', 'RUTA']);

echo "Found: " . $images->count() . " images\n\n";

foreach ($images as $img) {
    echo $img->NOMBRE_IMAGEN . ' => ' . $img->RUTA . "\n";
}

echo "\nChecking partial matches...\n\n";

$partialImages = DB::table('tabla_imagenes')
    ->where(function($query) {
        $query->where('NOMBRE_IMAGEN', 'like', '%Antioquia%')
              ->orWhere('NOMBRE_IMAGEN', 'like', '%Cundinamarca%')
              ->orWhere('NOMBRE_IMAGEN', 'like', '%Boyac%')
              ->orWhere('NOMBRE_IMAGEN', 'like', '%Caldas%')
              ->orWhere('NOMBRE_IMAGEN', 'like', '%Risaralda%')
              ->orWhere('NOMBRE_IMAGEN', 'like', '%Quind%');
    })
    ->get(['NOMBRE_IMAGEN', 'RUTA']);

echo "Found: " . $partialImages->count() . " partial matches\n\n";

foreach ($partialImages as $img) {
    echo $img->NOMBRE_IMAGEN . ' => ' . $img->RUTA . "\n";
}
