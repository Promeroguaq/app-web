<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING tabla_actividad_parques ===\n";
$first = DB::table('tabla_actividad_parques')->first();
if($first) {
    echo "Structure:\n";
    print_r($first);
} else {
    echo "No data in tabla_actividad_parques\n";
}

echo "\n=== CHECKING ALL tabla_ TABLES ===\n";
$tables = DB::select('SHOW TABLES LIKE "tabla_%"');
foreach($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "- $tableName\n";
    
    // Show first record structure
    $first = DB::table($tableName)->first();
    if($first) {
        echo "  Structure:\n";
        foreach($first as $key => $value) {
            echo "    $key: $value\n";
        }
        echo "\n";
    }
}
