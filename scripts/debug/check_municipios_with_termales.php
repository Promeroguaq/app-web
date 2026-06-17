<?php
require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== MUNICIPIOS CON TERMALES ===\n\n";
    
    // Obtener ID_LOCALITIES de termales
    $termales_localities = DB::table('tabla_termales')->select('ID_LOCALITIES')->distinct()->get();
    
    foreach ($termales_localities as $loc) {
        $locality_id = $loc->ID_LOCALITIES;
        echo "ID_LOCALITIES: $locality_id\n";
        
        // Buscar localidad
        $localidad = DB::table('tabla_localities')->where('ID_LOCALITIES', $locality_id)->first();
        if ($localidad) {
            echo "Nombre Localidad: {$localidad->NOMBRE_LOCALITIES}\n";
        }
        
        // Buscar municipios con esta localidad
        $municipios = DB::table('tabla_municipios')
            ->where('ID_LOCALITIES', $locality_id)
            ->join('tabla_departamentos', 'tabla_municipios.ID_DEPARTAMENTO', '=', 'tabla_departamentos.ID_DEPARTAMENTO')
            ->select('tabla_municipios.NOMBRE_MUNICIPIOS', 'tabla_departamentos.NOMBRE_DEPARTAMENTO')
            ->get();
        
        if ($municipios->count() > 0) {
            echo "Municipios:\n";
            foreach ($municipios as $municipio) {
                echo "  - {$municipio->NOMBRE_MUNICIPIOS} ({$municipio->NOMBRE_DEPARTAMENTO})\n";
            }
        } else {
            echo "No hay municipios con esta localidad\n";
        }
        
        echo "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
