<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECK TABLA_MUNICIPIOS ===\n";
$count = \DB::table('tabla_municipios')->count();
echo "Count: $count\n";

if ($count > 0) {
    echo "\n=== SAMPLE DATA ===\n";
    $sample = \DB::table('tabla_municipios')->limit(3)->get();
    foreach ($sample as $row) {
        echo "ID: {$row->ID_MUNICIPIOS}, Nombre: {$row->NOMBRE_MUNICIPIOS}, Dept: {$row->ID_DEPARTAMENTO}\n";
    }
}

echo "\n=== CHECK JOIN WITH DEPARTAMENTOS ===\n";
$joinCount = \DB::table('tabla_municipios')
    ->leftJoin('tabla_departamentos', 'tabla_municipios.ID_DEPARTAMENTO', '=', 'tabla_departamentos.ID_DEPARTAMENTO')
    ->count();
echo "Count with join: $joinCount\n";

echo "\n=== CHECK GROUP BY ===\n";
$groupByCount = \DB::table('tabla_municipios')
    ->leftJoin('tabla_departamentos', 'tabla_municipios.ID_DEPARTAMENTO', '=', 'tabla_departamentos.ID_DEPARTAMENTO')
    ->groupBy('tabla_municipios.ID_MUNICIPIOS')
    ->count();
echo "Count with groupBy: $groupByCount\n";
