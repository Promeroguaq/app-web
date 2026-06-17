<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing optimized query performance...\n\n";

$start = microtime(true);

// Test the optimized controller method
$controller = new \App\Http\Controllers\DestinosController();

try {
    $start = microtime(true);
    $destinos = $controller->obtenerDestinosDesdeBaseDeDatos();
    $methodTime = microtime(true) - $start;
    
    echo "Optimized method returned " . count($destinos) . " destinations in " . round($methodTime * 1000, 2) . "ms\n";
    
    // Test with filters
    echo "\nTesting with filters (categoria=Actividad en parque, departamento=Atlántico)...\n";
    
    $request = new \Illuminate\Http\Request([
        'categoria' => 'Actividad en parque',
        'departamento' => 'Atlántico'
    ]);
    
    $start = microtime(true);
    $result = $controller->index($request);
    $filterTime = microtime(true) - $start;
    
    echo "Filtered request completed in " . round($filterTime * 1000, 2) . "ms\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
