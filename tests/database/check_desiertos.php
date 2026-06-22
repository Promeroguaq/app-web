<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Check if table exists
    $tableExists = \Schema::hasTable('tabla_desierto_laguna');
    echo "Table 'tabla_desierto_laguna' exists: " . ($tableExists ? 'YES' : 'NO') . "\n";

    if ($tableExists) {
        // Get record count
        $count = \DB::table('tabla_desierto_laguna')->count();
        echo "Record count: " . $count . "\n";

        // Show first few records
        $records = \DB::table('tabla_desierto_laguna')->limit(3)->get();
        echo "\nFirst few records:\n";
        foreach ($records as $record) {
            echo "ID: {$record->{'COL 1'}}, Name: {$record->{'COL 2'}}\n";
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
