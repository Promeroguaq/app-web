<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Obtener datos de la tabla actividad_parques
$actividades = DB::table('actividad_parques')->get();

foreach ($actividades as $actividad) {
    echo $actividad->id_actividad . ' - ' . $actividad->nombre_actividad_en_parque . ' - ' . $actividad->descripcion . PHP_EOL;
}
