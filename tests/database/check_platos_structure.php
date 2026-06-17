<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

try {
    // Verificar qué tablas existen relacionadas con platos
    $tables = DB::select("SHOW TABLES LIKE '%plato%'");
    
    echo "=== TABLAS QUE CONTIENEN 'plato' ===\n\n";
    
    foreach ($tables as $table) {
        foreach ($table as $value) {
            echo "- " . $value . "\n";
        }
    }
    
    // Si no hay tablas con 'plato', buscar con 'gastronomia'
    if (empty($tables)) {
        $tables = DB::select("SHOW TABLES LIKE '%gastronomia%'");
        echo "\n=== TABLAS QUE CONTIENEN 'gastronomia' ===\n\n";
        
        foreach ($tables as $table) {
            foreach ($table as $value) {
                echo "- " . $value . "\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
