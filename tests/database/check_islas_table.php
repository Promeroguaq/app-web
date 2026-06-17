<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ESTRUCTURA DE TABLA_ISLAS ===\n";
$columns = DB::select('DESCRIBE tabla_islas');
foreach($columns as $col) {
    echo $col->Field . ' - ' . $col->Type . PHP_EOL;
}

echo "\n=== DATOS DE TABLA_ISLAS ===\n";
$islas = DB::table('tabla_islas')->limit(5)->get();
foreach($islas as $isla) {
    echo "ID: " . $isla->ID_ISLA . ", Nombre: " . $isla->NOMBRE_ISLA . ", Descripción: " . substr($isla->DESCRIPCION, 0, 50) . "...\n";
}
