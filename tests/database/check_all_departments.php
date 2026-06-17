<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking all departments...\n\n";

$departments = DB::table('departamentos')
    ->select('NOMBRE_DEPARTAMENTO')
    ->orderBy('NOMBRE_DEPARTAMENTO')
    ->get();

echo "All departments in database:\n";
foreach ($departments as $dept) {
    $name = trim($dept->NOMBRE_DEPARTAMENTO);
    echo "- '$name'\n";
}

echo "\nLooking for departments with 'Atl' in name:\n";
foreach ($departments as $dept) {
    $name = trim($dept->NOMBRE_DEPARTAMENTO);
    if (stripos($name, 'atl') !== false) {
        echo "- '$name' (POTENTIAL MATCH)\n";
    }
}

echo "\nTesting the exact filtering logic from controller:\n";
$requestDept = 'Atlántico'; // This is what comes from the URL parameter
echo "Looking for exact match with: '$requestDept'\n";

$exactMatch = DB::table('departamentos')
    ->whereRaw('TRIM(NOMBRE_DEPARTAMENTO) = ?', [trim($requestDept)])
    ->first();

if ($exactMatch) {
    echo "Found exact match: {$exactMatch->NOMBRE_DEPARTAMENTO}\n";
} else {
    echo "No exact match found\n";
    
    // Try case-insensitive
    $caseInsensitive = DB::table('departamentos')
        ->whereRaw('LOWER(TRIM(NOMBRE_DEPARTAMENTO)) = ?', [strtolower(trim($requestDept))])
        ->first();
        
    if ($caseInsensitive) {
        echo "Found case-insensitive match: {$caseInsensitive->NOMBRE_DEPARTAMENTO}\n";
    } else {
        echo "No case-insensitive match found either\n";
    }
}
