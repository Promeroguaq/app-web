<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ESTRUCTURA DE TABLA_IMAGENES ===\n";
$columns = DB::select('DESCRIBE tabla_imagenes');
foreach($columns as $col) {
    echo $col->Field . ' - ' . $col->Type . PHP_EOL;
}

echo "\n=== DATOS DE TABLA_IMAGENES ===\n";
$imagenes = DB::table('tabla_imagenes')->get();
foreach($imagenes as $imagen) {
    echo "ID: " . $imagen->ID_IMAGEN . ", Nombre: " . $imagen->NOMBRE_IMAGEN . ", Ruta: " . substr($imagen->RUTA, 0, 80) . "...\n";
}
