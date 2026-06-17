<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== IDS DE DEPARTAMENTOS ===\n\n";
$departamentos = DB::table('tabla_departamentos')->orderBy('NOMBRE_DEPARTAMENTO')->get();

foreach($departamentos as $depto) {
    echo "ID: " . $depto->ID_DEPARTAMENTO . " | " . $depto->NOMBRE_DEPARTAMENTO . "\n";
}
