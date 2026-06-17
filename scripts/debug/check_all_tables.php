<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== LISTANDO TODAS LAS TABLAS ===\n";
$tables = DB::select("SHOW TABLES");
foreach($tables as $table) {
    foreach($table as $key => $value) {
        echo "- $value\n";
    }
}

echo "\n=== TABLAS QUE EMPIEZAN CON 'tabla_' ===\n";
$tabla_tables = DB::select("SHOW TABLES LIKE 'tabla_%'");
foreach($tabla_tables as $table) {
    foreach($table as $key => $value) {
        echo "- $value\n";
    }
}
