<?php
require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $columns = DB::select("DESCRIBE tabla_termales");
    echo "=== ESTRUCTURA DE TABLA_TERMALES ===\n\n";
    foreach ($columns as $column) {
        echo "Campo: {$column->Field}\n";
        echo "Tipo: {$column->Type}\n";
        echo "Null: " . ($column->Null === 'YES' ? 'YES' : 'NO') . "\n";
        echo "Key: {$column->Key}\n";
        echo "Default: " . ($column->Default ?? 'NULL') . "\n";
        echo "Extra: {$column->Extra}\n";
        echo "--------------------------------\n";
    }
    
    echo "\n=== PRIMEROS 10 REGISTROS ===\n\n";
    $termales = DB::table('tabla_termales')->limit(10)->get();
    foreach ($termales as $termal) {
        echo json_encode($termal, JSON_UNESCAPED_UNICODE) . "\n\n";
    }
    
    echo "\n=== LOCALITIES ÚNICAS ===\n\n";
    $localities = DB::table('tabla_termales')->select('ID_LOCALITIES')->distinct()->get();
    foreach ($localities as $loc) {
        echo "ID_LOCALITIES: {$loc->ID_LOCALITIES}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
