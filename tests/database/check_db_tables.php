<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = DB::select('SHOW TABLES');
    echo "Tables in database:\n";
    foreach($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "- $tableName\n";
    }
    
    echo "\nChecking specific tables mentioned in controller:\n";
    $controllerTables = [
        'tabla_actividad_parque',
        'tabla_capitales',
        'tabla_ciclismo',
        'tabla_deporte_aventura',
        'tabla_desierto_laguna',
        'tabla_iglesias',
        'tabla_islas',
        'tabla_museos',
        'tabla_parque_tematicos',
        'tabla_playas',
        'tabla_reservas',
        'tabla_termales'
    ];
    
    foreach ($controllerTables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "- $table: $count records\n";
        } catch (Exception $e) {
            echo "- $table: ERROR - " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
