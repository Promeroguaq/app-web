<?php
require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $columns = DB::select("DESCRIBE tabla_municipios");
    echo "=== ESTRUCTURA DE TABLA_MUNICIPIOS ===\n\n";
    foreach ($columns as $column) {
        echo "Campo: {$column->Field}\n";
        echo "Tipo: {$column->Type}\n";
        echo "Null: " . ($column->Null === 'YES' ? 'YES' : 'NO') . "\n";
        echo "Key: {$column->Key}\n";
        echo "Default: " . ($column->Default ?? 'NULL') . "\n";
        echo "Extra: {$column->Extra}\n";
        echo "--------------------------------\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
