<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Check if table exists
    $tableExists = \Schema::hasTable('desierto_lagunas');
    echo "Table 'desierto_lagunas' exists: " . ($tableExists ? 'YES' : 'NO') . "\n";
    
    if ($tableExists) {
        // Get record count
        $count = \DB::table('desierto_lagunas')->count();
        echo "Record count: " . $count . "\n";
        
        // Show first few records
        $records = \DB::table('desierto_lagunas')->limit(3)->get();
        echo "\nFirst few records:\n";
        foreach ($records as $record) {
            echo "ID: {$record->id}, Name: {$record->nombre_desierto_lagunas}\n";
        }
    }
    
    // Check if there's a similar table name
    $tables = \DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name LIKE '%desierto%'");
    echo "\nTables with 'desierto' in name:\n";
    foreach ($tables as $table) {
        echo "- {$table->name}\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
