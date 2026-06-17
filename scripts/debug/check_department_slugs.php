<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking department slugs...\n\n";

$departments = DB::table('tabla_departamentos')
    ->whereIn('ID_DEPARTAMENTO', [5, 13, 23, 28, 30])
    ->get(['ID_DEPARTAMENTO', 'NOMBRE_DEPARTAMENTO']);

foreach ($departments as $dept) {
    echo "ID: " . $dept->ID_DEPARTAMENTO . " - Name: " . $dept->NOMBRE_DEPARTAMENTO . "\n";
}
