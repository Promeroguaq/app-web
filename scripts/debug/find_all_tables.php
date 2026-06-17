<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TODAS LAS TABLAS CON PREFIJO 'tabla_' ===\n";
try {
    $tables = DB::select('SHOW TABLES');
    foreach($tables as $table) {
        $tableName = array_values((array)$table)[0];
        if(stripos($tableName, 'tabla_') !== false) {
            echo "- " . $tableName . "\n";
        }
    }
} catch(Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
