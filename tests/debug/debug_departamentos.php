<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO ESTRUCTURA DE TABLA_DEPARTAMENTOS ===\n";
$columns = DB::select('DESCRIBE tabla_departamentos');
foreach($columns as $col) {
    echo $col->Field . ' - ' . $col->Type . PHP_EOL;
}

echo "\n=== VERIFICANDO PRIMEROS 5 DEPARTAMENTOS ===\n";
$departamentos = DB::table('tabla_departamentos')->limit(5)->get();
foreach($departamentos as $depto) {
    echo "ID: " . $depto->ID_DEPARTAMENTO . ", Nombre: " . $depto->NOMBRE_DEPARTAMENTO . "\n";
    // Verificar si tiene campo de capital
    if(isset($depto->ID_CIUDAD_CAPITAL)) {
        echo "  Capital ID: " . $depto->ID_CIUDAD_CAPITAL . "\n";
    }
    if(isset($depto->DESCRIPCION_DEPARTAMENTO)) {
        echo "  Descripción: " . substr($depto->DESCRIPCION_DEPARTAMENTO, 0, 50) . "...\n";
    }
}

echo "\n=== VERIFICANDO ESTRUCTURA DE TABLA_IMAGENES ===\n";
$columns = DB::select('DESCRIBE tabla_imagenes');
foreach($columns as $col) {
    echo $col->Field . ' - ' . $col->Type . PHP_EOL;
}

echo "\n=== VERIFICANDO SI TIENE ID_CIUDAD ===\n";
$imagenes = DB::table('tabla_imagenes')->limit(3)->get();
foreach($imagenes as $img) {
    echo "ID: " . $img->ID_IMAGEN . ", Nombre: " . $img->NOMBRE_IMAGEN . "\n";
    if(isset($img->ID_CIUDAD)) {
        echo "  ID_CIUDAD: " . $img->ID_CIUDAD . "\n";
    }
}
