<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking tabla_capitales structure...\n\n";

// Check if table exists
$tableExists = \Schema::hasTable('tabla_capitales');
echo "Table exists: " . ($tableExists ? 'YES' : 'NO') . "\n\n";

if ($tableExists) {
    // Get columns
    $columns = \Schema::getColumnListing('tabla_capitales');
    echo "Columns:\n";
    foreach ($columns as $col) {
        echo "  - $col\n";
    }

    echo "\n\nSample data (first 5):\n";
    $sample = \DB::table('tabla_capitales')->limit(5)->get();
    foreach ($sample as $row) {
        echo "  " . json_encode((array)$row, JSON_UNESCAPED_UNICODE) . "\n";
    }

    echo "\n\nTotal count: " . \DB::table('tabla_capitales')->count() . "\n";
} else {
    echo "Table tabla_capitales does not exist.\n";
}
