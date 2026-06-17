<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    // Usar la conexión de Laravel para ver la estructura real
    $schema = DB::select("DESCRIBE tabla_actividad_parque");
    
    echo "=== ESTRUCTURA REAL DE tabla_actividad_parque ===\n\n";
    
    foreach ($schema as $column) {
        echo "Columna: " . $column->Field . "\n";
        echo "Tipo: " . $column->Type . "\n";
        echo "------------------------\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    // Intentar ver qué tablas existen
    try {
        $tables = DB::select("SHOW TABLES LIKE '%actividad%'");
        echo "\n=== TABLAS QUE CONTIENEN 'actividad' ===\n\n";
        
        foreach ($tables as $table) {
            foreach ($table as $value) {
                echo "- " . $value . "\n";
            }
        }
    } catch (Exception $e2) {
        echo "No se pudo obtener tablas: " . $e2->getMessage() . "\n";
    }
}
