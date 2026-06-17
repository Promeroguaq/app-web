<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking exact department names...\n\n";

$departments = DB::table('departamentos')
    ->select('id_departamento', 'nombre_departamento')
    ->orderBy('nombre_departamento')
    ->get();

echo "All departments:\n";
foreach ($departments as $depto) {
    $name = trim($depto->nombre_departamento);
    echo "- ID: {$depto->id_departamento}, Name: '$name'\n";
}

echo "\nLooking for departments with 'Atl' in name:\n";
foreach ($departments as $depto) {
    $name = trim($depto->nombre_departamento);
    if (stripos($name, 'atl') !== false) {
        echo "- ID: {$depto->id_departamento}, Name: '$name' (MATCH)\n";
    }
}

echo "\nTesting exact match with 'Atlántico':\n";
$match = DB::table('departamentos')
    ->where('nombre_departamento', 'Atlántico')
    ->first();

if ($match) {
    echo "Found: ID {$match->id_departamento}\n";
} else {
    echo "No exact match found for 'Atlántico'\n";
    
    // Try URL decoded version
    $decoded = urldecode('Atl%C3%A1ntico');
    echo "Trying decoded version: '$decoded'\n";
    $match2 = DB::table('departamentos')
        ->where('nombre_departamento', $decoded)
        ->first();
        
    if ($match2) {
        echo "Found decoded: ID {$match2->id_departamento}\n";
    } else {
        echo "No decoded match found either\n";
    }
}
