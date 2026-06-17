<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ESTRUCTURA DE LA TABLA tabla_imagenes ===\n";
try {
    $columns = DB::select("DESCRIBE tabla_imagenes");
    foreach($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
    
    echo "\n=== PRIMEROS REGISTROS ===\n";
    $registros = DB::table('tabla_imagenes')->limit(3)->get();
    foreach($registros as $registro) {
        echo "Registro: " . json_encode((array)$registro) . "\n\n";
    }
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
