<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO COLUMNAS DE IMAGEN EN TABLAS DE CATEGORÍAS ===\n\n";

$tabla_tables = [
    'tabla_playas',
    'tabla_museos',
    'tabla_iglesias',
    'tabla_gastronomia',
    'tabla_termales',
    'tabla_reservas',
    'tabla_parque_tematicos',
    'tabla_deporte_aventura',
    'tabla_desierto_laguna',
    'tabla_ferias',
    'tabla_ciclismo',
    'tabla_actividad_parque',
    'tabla_islas',
    'tabla_capitales',
    'tabla_regiones'
];

foreach($tabla_tables as $table) {
    try {
        $columns = DB::select("DESCRIBE $table");
        echo "--- $table ---\n";
        foreach($columns as $column) {
            echo "  " . $column->Field . " (" . $column->Type . ")\n";
        }
        echo "\n";
    } catch(Exception $e) {
        echo "$table: Error - " . $e->getMessage() . "\n\n";
    }
}
