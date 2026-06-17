<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO TABLA DE EVENTOS ===\n";

try {
    $eventos = DB::table('ferias_fiestas')->count();
    echo "Tabla ferias_fiestas: $eventos registros\n";
    
    if ($eventos > 0) {
        $sample = DB::table('ferias_fiestas')->limit(3)->get();
        foreach ($sample as $evento) {
            echo "- {$evento->NOMBRE_FERIA_FIESTA}\n";
            echo "  Tipo: {$evento->TIPO}\n";
            echo "  Departamento: {$evento->DEPARTAMENTO}\n";
            echo "  Fecha: {$evento->FECHA_INICIO} - {$evento->FECHA_FIN}\n\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICANDO SI EXISTE EVENTOSCONTROLLER ===\n";
if (file_exists('app/Http/Controllers/EventosController.php')) {
    echo "✅ EventosController.php existe\n";
} else {
    echo "❌ EventosController.php no existe - necesita crearse\n";
}

echo "\n=== VERIFICANDO SI EXISTE VISTA DE EVENTOS ===\n";
if (file_exists('resources/views/pages/eventos.blade.php')) {
    echo "✅ eventos.blade.php existe\n";
} else {
    echo "❌ eventos.blade.php no existe - necesita crearse\n";
}
