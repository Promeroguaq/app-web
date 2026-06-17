<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PROBANDO MATCHING EXACTO PARA YOPAL ===\n";

$capital = 'Yopal';
$imagenes_capitales = DB::table('tabla_imagenes')
    ->where('NOMBRE_IMAGEN', 'like', '%capital%')
    ->orWhere('RUTA', 'like', '%/capital_cities/%')
    ->get();

echo "Buscando: '$capital'\n";
echo "Capital limpio: '" . strtolower(str_replace(' ', '', $capital)) . "'\n\n";

foreach($imagenes_capitales as $imagen) {
    echo "Imagen: " . $imagen->NOMBRE_IMAGEN . "\n";
    echo "Ruta: " . $imagen->RUTA . "\n";
    
    // Test 1: Buscar por nombre de imagen
    if (stripos($imagen->NOMBRE_IMAGEN, $capital) !== false) {
        echo "  ✅ ENCONTRADO por nombre\n";
        break;
    }
    
    // Test 2: Buscar por ruta
    $capital_clean = strtolower(str_replace(' ', '', $capital));
    if (stripos($imagen->RUTA, $capital_clean) !== false) {
        echo "  ✅ ENCONTRADO por ruta\n";
        break;
    }
    
    echo "  ❌ No encontrado\n";
    echo "\n";
}
