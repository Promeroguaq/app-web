<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking URL parameter and actual test...\n\n";

// Test the exact URL that was failing
$url = 'http://127.0.0.1:8000/destinos?categoria=Actividad%20en%20parque&departamento=Atl%C3%A1ntico';

echo "Original URL: $url\n";

// Parse the URL parameter
$parts = parse_url($url);
parse_str($parts['query'], $params);

echo "Parsed parameters:\n";
foreach ($params as $key => $value) {
    echo "- $key: '$value' (decoded: '" . urldecode($value) . "')\n";
}

// Test with the actual controller using these parameters
$request = new \Illuminate\Http\Request($params);

echo "\nTesting with actual URL parameters:\n";
$start = microtime(true);
$controller = new \App\Http\Controllers\DestinosController();
try {
    $response = $controller->index($request);
    $time = microtime(true) - $start;
    echo "Success: " . count($response['destinos']) . " destinations in " . round($time * 1000, 2) . "ms\n";
} catch (Exception $e) {
    $time = microtime(true) - $start;
    echo "Error after " . round($time * 1000, 2) . "ms: " . $e->getMessage() . "\n";
}

// Check if departments table has any data
echo "\nChecking departments table data:\n";
$count = DB::table('departamentos')->count();
echo "Total departments: $count\n";

if ($count > 0) {
    $sample = DB::table('departamentos')->limit(5)->get();
    foreach ($sample as $depto) {
        echo "- '{$depto->nombre_departamento}'\n";
    }
} else {
    echo "Departments table is empty\n";
}

// Check if we have any activities at all
echo "\nChecking activities table:\n";
$activityCount = DB::table('tabla_actividad_parque')->count();
echo "Total activities: $activityCount\n";
