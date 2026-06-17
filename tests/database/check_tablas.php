<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get all tables that start with 'tabla_'
$tables = DB::select('SHOW TABLES LIKE "tabla_%"');

echo "=== TABLAS QUE COMIENZAN CON 'tabla_' ===\n";
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "- $tableName\n";
}

echo "\n=== VERIFICANDO INFORMACIÓN DE CATEGORÍAS Y UBICACIONES ===\n";

// Check capitales (departments)
echo "\n--- CAPITALES (DEPARTAMENTOS) ---\n";
$capitales = DB::table('capitales')->get();
foreach ($capitales as $capital) {
    echo "ID: {$capital->id}, Nombre: {$capital->nombre}, Departamento: {$capital->departamento}\n";
}

// Check departamentos
echo "\n--- DEPARTAMENTOS ---\n";
$departamentos = DB::table('departamentos')->get();
foreach ($departamentos as $depto) {
    echo "ID: {$depto->id}, Nombre: {$depto->nombre}\n";
}

// Check municipios
echo "\n--- MUNICIPIOS ---\n";
$municipios = DB::table('municipios')->limit(10)->get();
foreach ($municipios as $municipio) {
    echo "ID: {$municipio->id}, Nombre: {$municipio->nombre}, Departamento_ID: {$municipio->departamento_id}\n";
}

// Check categorías gastronomicas
echo "\n--- CATEGORÍAS GASTRONÓMICAS ---\n";
$categorias = DB::table('categorias_gastronomicas')->get();
foreach ($categorias as $categoria) {
    echo "ID: {$categoria->id}, Nombre: {$categoria->nombre}\n";
}

// Check some activity tables
echo "\n--- ACTIVIDADES PARQUES ---\n";
$actividades = DB::table('actividades_parques')->limit(5)->get();
foreach ($actividades as $actividad) {
    echo "ID: {$actividad->id}, Nombre: {$actividad->nombre}, Parque_ID: {$actividad->parque_tematico_id}\n";
}

echo "\n=== TOTAL DE REGISTROS POR TABLA ===\n";
$tables_to_check = [
    'capitales', 'departamentos', 'municipios', 'categorias_gastronomicas',
    'actividades_parques', 'parques_tematicos', 'playas', 'museos', 'iglesias'
];

foreach ($tables_to_check as $table) {
    try {
        $count = DB::table($table)->count();
        echo "$table: $count registros\n";
    } catch (Exception $e) {
        echo "$table: Error - " . $e->getMessage() . "\n";
    }
}
