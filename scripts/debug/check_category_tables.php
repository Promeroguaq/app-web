<?php
require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$category_tables = [
    'tabla_playas',
    'tabla_museos',
    'tabla_gastronomia',
    'tabla_iglesias',
    'tabla_parque_tematicos',
    'tabla_termales',
    'tabla_actividad_parque',
    'tabla_ciclismo',
    'tabla_deporte_aventura',
    'tabla_desierto_laguna',
    'tabla_islas'
];

foreach ($category_tables as $table) {
    try {
        $columns = DB::select("DESCRIBE $table");
        echo "=== TABLA: $table ===\n";
        foreach ($columns as $column) {
            echo "  {$column->Field} ({$column->Type})\n";
        }
        
        $count = DB::table($table)->count();
        echo "  Total registros: $count\n";
        
        $sample = DB::table($table)->limit(1)->first();
        if ($sample) {
            echo "  Ejemplo: " . json_encode($sample, JSON_UNESCAPED_UNICODE) . "\n";
        }
        echo "\n";
    } catch (Exception $e) {
        echo "Error en $table: " . $e->getMessage() . "\n\n";
    }
}
