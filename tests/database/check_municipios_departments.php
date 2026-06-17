<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking municipios and departments data...\n\n";

// Check municipios table structure and data
echo "Municipios table structure:\n";
$columns = DB::select("SHOW COLUMNS FROM municipios");
foreach ($columns as $column) {
    echo "- {$column->Field}\n";
}

echo "\nSample municipios data:\n";
$municipios = DB::table('municipios')->limit(10)->get();
foreach ($municipios as $municipio) {
    $data = (array)$municipio;
    echo "- " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
}

// Check if there's a relationship to departments
echo "\nChecking for department references in municipios:\n";
$deptReferences = DB::table('municipios')
    ->select('ID_DEPARTAMENTO')
    ->distinct()
    ->whereNotNull('ID_DEPARTAMENTO')
    ->limit(5)
    ->get();
    
foreach ($deptReferences as $ref) {
    echo "- Department ID: {$ref->ID_DEPARTAMENTO}\n";
}

// Check if there are any activities with locality 13 (from earlier sample)
echo "\nChecking activities with locality ID 13:\n";
$activities = DB::table('tabla_actividad_parque')
    ->where('ID_LOCALITITES', '13')
    ->get();
    
echo "Found " . count($activities) . " activities with locality 13:\n";
foreach ($activities as $activity) {
    echo "- {$activity->NOMBRE_ACTIVIDAD_EN_PARQUE}\n";
}

// Find which municipality has locality 13
echo "\nFinding municipality with locality 13:\n";
$municipio13 = DB::table('municipios')
    ->where('ID_LOCALITIES', '13')
    ->first();
    
if ($municipio13) {
    echo "Found: {$municipio13->NOMBRE_MUNICIPIOS} (Dept ID: " . ($municipio13->ID_DEPARTAMENTO ?? 'NULL') . ")\n";
} else {
    echo "No municipality found with locality 13\n";
}
