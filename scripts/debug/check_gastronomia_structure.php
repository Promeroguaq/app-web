<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO ESTRUCTURA DE TABLAS FALTANTES ===\n";

// Check gastronomia table structure
echo "Tabla: tabla_gastronomia\n";
try {
    $columns = DB::select("DESCRIBE tabla_gastronomia");
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})\n";
    }
    echo "\n";
    
    $sample = DB::table('tabla_gastronomia')->limit(2)->get();
    foreach ($sample as $record) {
        echo "Sample record:\n";
        foreach ((array)$record as $key => $value) {
            echo "  $key: " . substr($value, 0, 50) . "...\n";
        }
        echo "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nTabla: tabla_regiones\n";
try {
    $columns = DB::select("DESCRIBE tabla_regiones");
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})\n";
    }
    
    $sample = DB::table('tabla_regiones')->limit(2)->get();
    foreach ($sample as $record) {
        echo "Sample record:\n";
        foreach ((array)$record as $key => $value) {
            echo "  $key: $value\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICANDO PLATOS TÍPICOS ===\n";
try {
    $platos = DB::table('plato_tipicos')->count();
    echo "plato_tipicos - Registros: $platos\n";
    
    if ($platos > 0) {
        $sample = DB::table('plato_tipicos')->limit(2)->get();
        foreach ($sample as $record) {
            echo "Sample plato:\n";
            foreach ((array)$record as $key => $value) {
                echo "  $key: " . substr($value, 0, 30) . "...\n";
            }
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
