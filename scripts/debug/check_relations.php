<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO RELACIONES EN TABLAS PRINCIPALES ===\n\n";

// Check departamentos
echo "--- TABLA_DEPARTAMENTOS ---\n";
try {
    $columns = DB::select("DESCRIBE tabla_departamentos");
    foreach($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

echo "\n--- TABLA_MUNICIPIOS ---\n";
try {
    $columns = DB::select("DESCRIBE tabla_municipios");
    foreach($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

echo "\n=== BUSCANDO COLUMNAS DE IMAGEN ===\n";
$tables = ['tabla_departamentos', 'tabla_municipios', 'tabla_puntos_interes'];
foreach($tables as $table) {
    try {
        $columns = DB::select("DESCRIBE $table");
        $has_image = false;
        foreach($columns as $column) {
            if (stripos($column->Field, 'imagen') !== false || stripos($column->Field, 'image') !== false || stripos($column->Field, 'foto') !== false) {
                echo "$table tiene columna: " . $column->Field . "\n";
                $has_image = true;
            }
        }
        if (!$has_image) {
            echo "$table NO tiene columnas de imagen\n";
        }
    } catch(Exception $e) {
        echo "$table: Error - " . $e->getMessage() . "\n";
    }
}
