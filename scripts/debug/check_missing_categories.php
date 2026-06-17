<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICANDO TABLAS EXISTENTES ===\n";

// Get all tables in the database
$tables = DB::select("SHOW TABLES");
$table_names = [];
foreach ($tables as $table) {
    $table_names[] = array_values((array)$table)[0];
}

echo "Tablas encontradas:\n";
foreach ($table_names as $table) {
    echo "- $table\n";
}

echo "\n=== VERIFICANDO TABLAS DE CATEGORÍAS FALTANTES ===\n";

$missing_tables = [
    'tabla_gastronomia' => 'Gastronomía',
    'tabla_recetas' => 'Recetas',
    'tabla_platos_tipicos' => 'Platos típicos',
    'tabla_regiones' => 'Regiones',
    'tabla_regiones_naturales' => 'Regiones naturales'
];

foreach ($missing_tables as $table => $description) {
    if (in_array($table, $table_names)) {
        echo "✅ $table ($description) - EXISTE\n";
        try {
            $count = DB::table($table)->count();
            echo "   Registros: $count\n";
        } catch (\Exception $e) {
            echo "   Error al contar: " . $e->getMessage() . "\n";
        }
    } else {
        echo "❌ $table ($description) - NO EXISTE\n";
    }
}

echo "\n=== VERIFICANDO CATEGORÍAS EN DESTINOSCONTROLLER ===\n";

// Check what categories are currently in the controller
$controller_file = 'app/Http/Controllers/DestinosController.php';
if (file_exists($controller_file)) {
    $content = file_get_contents($controller_file);
    
    // Find the categories array
    preg_match('/\$categorias = \[.*?\];/s', $content, $matches);
    if ($matches) {
        echo "Categorías actuales en el controlador:\n";
        $categories_str = $matches[0];
        
        // Extract category names
        preg_match_all("/'categoria' => '([^']+)'/", $categories_str, $category_matches);
        foreach ($category_matches[1] as $category) {
            echo "- $category\n";
        }
    }
}

echo "\n=== VERIFICANDO IGLESIAS Y TERMALES ===\n";

// Check if these tables are being used
$existing_tables = [
    'tabla_iglesias' => 'Iglesias',
    'tabla_termales' => 'Termales',
    'tabla_desierto_laguna' => 'Desiertos/Lagunas',
    'tabla_reservas' => 'Reservas naturales'
];

foreach ($existing_tables as $table => $description) {
    if (in_array($table, $table_names)) {
        $count = DB::table($table)->count();
        echo "✅ $table ($description) - $count registros\n";
    } else {
        echo "❌ $table ($description) - NO EXISTE\n";
    }
}
