<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TABLAS QUE CONTIENEN 'MUNICIPIO' ===\n";
$tables = \DB::select('SHOW TABLES');
foreach($tables as $table) {
    foreach($table as $name) {
        if(stripos($name, 'municip') !== false) {
            echo "- $name\n";
        }
    }
}

echo "\n=== ESTRUCTURA DE TABLA MUNICIPIOS ===\n";
$municipios = \DB::select('DESCRIBE municipios');
foreach ($municipios as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA TABLA_MUNICIPIOS ===\n";
$tabla_municipios = \DB::select('DESCRIBE tabla_municipios');
foreach ($tabla_municipios as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== TABLAS QUE CONTIENEN 'LOCALIT' ===\n";
foreach($tables as $table) {
    foreach($table as $name) {
        if(stripos($name, 'localit') !== false) {
            echo "- $name\n";
        }
    }
}
