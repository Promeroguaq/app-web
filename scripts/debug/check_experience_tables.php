<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking for experience-related tables...\n\n";

// Get all tables
$tables = DB::select("SHOW TABLES");
$tableNames = [];
foreach ($tables as $table) {
    foreach ($table as $value) {
        $tableNames[] = $value;
    }
}

echo "All tables:\n";
foreach ($tableNames as $name) {
    echo "  - $name\n";
}

echo "\n\nSearching for experience-related tables:\n";
$keywords = ['experiencia', 'actividad', 'evento', 'cultura', 'gastronomia', 'turismo', 'interes', 'lugar'];
foreach ($tableNames as $name) {
    $lower = strtolower($name);
    foreach ($keywords as $keyword) {
        if (strpos($lower, $keyword) !== false) {
            echo "  MATCH: $name (contains '$keyword')\n";
            break;
        }
    }
}
