<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ESTRUCTURA DE TABLA PLAYAS ===\n";
$playas = \DB::select('DESCRIBE tabla_playas');
foreach ($playas as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA DEPORTE_AVENTURA ===\n";
$deportes = \DB::select('DESCRIBE tabla_deporte_aventura');
foreach ($deportes as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA TERMALES ===\n";
$termales = \DB::select('DESCRIBE tabla_termales');
foreach ($termales as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA RESERVAS ===\n";
$reservas = \DB::select('DESCRIBE tabla_reservas');
foreach ($reservas as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA MUSEOS ===\n";
$museos = \DB::select('DESCRIBE tabla_museos');
foreach ($museos as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA IGLESIAS ===\n";
$iglesias = \DB::select('DESCRIBE tabla_iglesias');
foreach ($iglesias as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA PARQUE_TEMATICOS ===\n";
$parques = \DB::select('DESCRIBE tabla_parque_tematicos');
foreach ($parques as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA ACTIVIDAD_PARQUE ===\n";
$actividades = \DB::select('DESCRIBE tabla_actividad_parque');
foreach ($actividades as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}

echo "\n=== ESTRUCTURA DE TABLA DESIERTO_LAGUNA ===\n";
$desiertos = \DB::select('DESCRIBE tabla_desierto_laguna');
foreach ($desiertos as $campo) {
    echo "- {$campo->Field} ({$campo->Type})\n";
}
