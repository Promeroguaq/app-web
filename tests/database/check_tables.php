<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Conectar a la base de datos SQLite directamente
$dbPath = database_path('database.sqlite');
$pdo = new PDO('sqlite:' . $dbPath);

// Listar todas las tablas
$stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table'");
$stmt->execute();

echo "=== TABLAS EN LA BASE DE DATOS ===\n\n";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- " . $row['name'] . "\n";
}

echo "\n";

// Verificar si existe actividad_parques
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM sqlite_master WHERE type='table' AND name='actividad_parques'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo "¿Existe tabla 'actividad_parques'? " . ($result['count'] > 0 ? 'SÍ' : 'NO') . "\n";

$pdo = null;
