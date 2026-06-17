<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    // Verificar la estructura real de tabla_gastronomia
    $schema = DB::select("DESCRIBE tabla_gastronomia");
    
    echo "=== ESTRUCTURA REAL DE tabla_gastronomia ===\n\n";
    
    foreach ($schema as $column) {
        echo "Columna: " . $column->Field . "\n";
        echo "Tipo: " . $column->Type . "\n";
        echo "------------------------\n";
    }
    
    // Verificar si hay datos
    $count = DB::select("SELECT COUNT(*) as count FROM tabla_gastronomia");
    echo "\nTotal de registros: " . $count[0]->count . "\n";
    
    if ($count[0]->count > 0) {
        $data = DB::select("SELECT * FROM tabla_gastronomia LIMIT 3");
        echo "\n=== PRIMEROS 3 REGISTROS ===\n\n";
        foreach ($data as $row) {
            foreach ($row as $key => $value) {
                echo "$key: $value\n";
            }
            echo "----------------------------------------\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
