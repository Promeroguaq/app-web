<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BUSCANDO TABLAS PARA EVENTOS/FERIAS ===\n";
try {
    $tables = DB::select('SHOW TABLES');
    foreach($tables as $table) {
        $tableName = array_values((array)$table)[0];
        if(stripos($tableName, 'feri') !== false || stripos($tableName, 'fiesta') !== false) {
            echo "Tabla encontrada: " . $tableName . "\n";
            $count = DB::table($tableName)->count();
            echo "Registros: $count\n\n";
        }
    }
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

echo "\n=== BUSCANDO TABLAS PARA DESIERTOS/LAGUNAS ===\n";
try {
    $tables = DB::select('SHOW TABLES');
    foreach($tables as $table) {
        $tableName = array_values((array)$table)[0];
        if(stripos($tableName, 'desierto') !== false || stripos($tableName, 'laguna') !== false) {
            echo "Tabla encontrada: " . $tableName . "\n";
            $count = DB::table($tableName)->count();
            echo "Registros: $count\n\n";
        }
    }
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
