<?php
require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Buscar tablas que podrían contener "localities" o "localidad"
    $tables = DB::select("SHOW TABLES");
    echo "=== TABLAS EN LA BASE DE DATOS ===\n\n";
    foreach ($tables as $table) {
        foreach ($table as $key => $value) {
            if (stripos($value, 'local') !== false) {
                echo "- $value (posible tabla de localidades)\n";
            }
        }
    }
    
    echo "\n=== VERIFICANDO SI EXISTE TABLA LOCALITIES ===\n\n";
    $exists = DB::select("SHOW TABLES LIKE '%local%'");
    if (count($exists) > 0) {
        foreach ($exists as $table) {
            foreach ($table as $key => $value) {
                echo "Encontrada: $value\n";
                $columns = DB::select("DESCRIBE $value");
                echo "Campos:\n";
                foreach ($columns as $col) {
                    echo "  {$col->Field}\n";
                }
            }
        }
    } else {
        echo "No se encontraron tablas con 'local' en el nombre\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
