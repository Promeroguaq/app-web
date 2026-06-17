<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Isla;
use App\Models\Playa;
use App\Models\Museo;
use App\Models\Iglesia;
use App\Models\DeporteAventura;
use App\Models\DesiertoLaguna;
use App\Models\ParqueTematico;
use App\Models\Termal;
use App\Models\Departamento;
use App\Models\ActividadParque;
use App\Models\Ciclismo;
use App\Models\FeriaFiesta;
use App\Models\PlatoTipico;

echo "=== VERIFICACIÓN DE DATOS PARA DASHBOARD ===\n\n";

$models = [
    'Isla' => new Isla(),
    'Playa' => new Playa(),
    'Museo' => new Museo(),
    'Iglesia' => new Iglesia(),
    'DeporteAventura' => new DeporteAventura(),
    'DesiertoLaguna' => new DesiertoLaguna(),
    'ParqueTematico' => new ParqueTematico(),
    'Termal' => new Termal(),
    'Departamento' => new Departamento(),
    'ActividadParque' => new ActividadParque(),
    'Ciclismo' => new Ciclismo(),
    'FeriaFiesta' => new FeriaFiesta(),
    'PlatoTipico' => new PlatoTipico(),
];

foreach ($models as $name => $model) {
    try {
        $table = $model->getTable();
        $count = $model->count();
        echo "$name: Tabla='$table', Count=$count\n";
    } catch (\Exception $e) {
        echo "$name: ERROR - " . $e->getMessage() . "\n";
    }
}

echo "\n=== TOTALES ===\n";
try {
    $totalDestinos = 
        (new Isla())->count() +
        (new Playa())->count() +
        (new Museo())->count() +
        (new Iglesia())->count() +
        (new DeporteAventura())->count() +
        (new DesiertoLaguna())->count() +
        (new ParqueTematico())->count() +
        (new Termal())->count();
    
    echo "Total Destinos: $totalDestinos\n";
} catch (\Exception $e) {
    echo "Error calculando total destinos: " . $e->getMessage() . "\n";
}
