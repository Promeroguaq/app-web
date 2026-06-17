<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking departments table structure...\n\n";

// Get table name
$table = 'tabla_departamentos';

// Get columns (MySQL)
$columns = DB::select("DESCRIBE $table");
echo "Columns in '$table':\n";
foreach ($columns as $col) {
    echo "  - " . $col->Field . " (" . $col->Type . ")\n";
}

echo "\nSample data:\n";
$sample = DB::table($table)->limit(5)->get();
foreach ($sample as $row) {
    echo "  " . json_encode((array)$row) . "\n";
}

echo "\nSearching for specific departments:\n";
$searchTerms = ['Chocó', 'Valle del Cauca', 'Cauca', 'Nariño'];
foreach ($searchTerms as $term) {
    $results = DB::table($table)->where('NOMBRE_DEPARTAMENTO', 'like', "%$term%")->get();
    echo "\n  '$term': " . count($results) . " results\n";
    foreach ($results as $r) {
        echo "    ID: " . $r->ID_DEPARTAMENTO . " - Name: " . $r->NOMBRE_DEPARTAMENTO . "\n";
    }
}
