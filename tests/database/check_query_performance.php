<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing query performance...\n\n";

$start = microtime(true);

// Test the problematic method
$controller = new \App\Http\Controllers\DestinosController();

// Test individual table queries
$tables = [
    'tabla_actividad_parque' => 'NOMBRE_ACTIVIDAD_EN_PARQUE',
    'tabla_capitales' => 'NOMBRE_CAPITAL',
    'tabla_ciclismo' => 'NOMBRE_RUTA_CICLISMO',
    'tabla_deporte_aventura' => 'NOMBRE_DEPORTES_AVENTURA',
    'tabla_desierto_laguna' => 'COL 2',
    'tabla_iglesias' => 'NOMBRE_IGLESIA',
    'tabla_islas' => 'NOMBRE_ISLA',
    'tabla_museos' => 'NOMBRE_MUSEO',
    'tabla_parque_tematicos' => 'NOMBRE_PARQUES_TEMÁTICOS',
    'tabla_playas' => 'NOMBRE_PLAYA',
    'tabla_reservas' => 'NOMBRE_RESERVAS_O_PARQUES',
    'tabla_termales' => 'NOMBRE_TERMAL'
];

$totalRecords = 0;
foreach ($tables as $table => $orderField) {
    $tableStart = microtime(true);
    try {
        $count = DB::table($table)->count();
        $sample = DB::table($table)->limit(5)->get();
        $tableTime = microtime(true) - $tableStart;
        $totalRecords += $count;
        echo "- $table: $count records (query time: " . round($tableTime * 1000, 2) . "ms)\n";
    } catch (Exception $e) {
        echo "- $table: ERROR - " . $e->getMessage() . "\n";
    }
}

$totalTime = microtime(true) - $start;
echo "\nTotal records processed: $totalRecords\n";
echo "Total query time: " . round($totalTime * 1000, 2) . "ms\n";

// Test the full controller method
echo "\nTesting full controller method...\n";
$start = microtime(true);
try {
    $destinos = $controller->obtenerDestinosDesdeBaseDeDatos();
    $methodTime = microtime(true) - $start;
    echo "Full method returned " . count($destinos) . " destinations in " . round($methodTime * 1000, 2) . "ms\n";
} catch (Exception $e) {
    echo "Error in full method: " . $e->getMessage() . "\n";
}
