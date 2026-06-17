<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging departments count issue...\n\n";

// Check the exact same query the controller is using
$departamentos = DB::table('departamentos')
    ->select('id_departamento as ID_DEPARTAMENTO', 'nombre_departamento as NOMBRE_DEPARTAMENTO')
    ->orderBy('nombre_departamento')
    ->get();

echo "Departments count from controller query: " . count($departamentos) . "\n";

// Check if the table actually exists and has data
echo "\nRaw check:\n";
try {
    $rawCount = DB::table('departamentos')->count();
    echo "Raw count: $rawCount\n";
} catch (Exception $e) {
    echo "Error counting: " . $e->getMessage() . "\n";
}

// Check if there's a different table name
echo "\nChecking for alternative department tables:\n";
$tables = DB::select("SHOW TABLES");
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    if (stripos($tableName, 'departamento') !== false) {
        echo "- Found table: $tableName\n";
        try {
            $count = DB::table($tableName)->count();
            echo "  Count: $count\n";
        } catch (Exception $e) {
            echo "  Error: " . $e->getMessage() . "\n";
        }
    }
}

// Test the controller logic directly
echo "\nTesting controller logic:\n";
$request = new \Illuminate\Http\Request([
    'categoria' => 'Actividad en parque',
    'departamento' => 'Atlántico'
]);

echo "Request departamento: '{$request->departamento}'\n";
echo "Request filled: " . ($request->filled('departamento') ? 'YES' : 'NO') . "\n";
echo "Not all departments: " . ($request->departamento !== 'Todos los departamentos' ? 'YES' : 'NO') . "\n";
echo "Departments count: " . count($departamentos) . "\n";
echo "Departments === 0: " . (count($departamentos) === 0 ? 'YES' : 'NO') . "\n";
