<?php

function normalizeText($text)
{
    $text = strtolower($text);
    $text = preg_replace('/[áàäâã]/', 'a', $text);
    $text = preg_replace('/[éèëê]/', 'e', $text);
    $text = preg_replace('/[íìïî]/', 'i', $text);
    $text = preg_replace('/[óòöôõ]/', 'o', $text);
    $text = preg_replace('/[úùüû]/', 'u', $text);
    $text = preg_replace('/[ñ]/', 'n', $text);
    $text = preg_replace('/[^a-z0-9-]/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return trim($text, '-');
}

$testNames = [
    'Chocó',
    'Valle del Cauca',
    'Cauca',
    'Nariño',
    'Antioquia',
    'Santander',
    'Bolívar',
    'Boyacá',
    'Caquetá',
    'Archipiélago de San Andrés, Providencia y Santa Catalina'
];

echo "Testing normalizeText():\n\n";
foreach ($testNames as $name) {
    $slug = normalizeText($name);
    echo "$name => $slug\n";
}
