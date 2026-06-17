<?php
$directory = __DIR__ . '/../resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

$replacements = [
    '🏛️' => '<i class="fas fa-landmark"></i>',
    '🏘️' => '<i class="fas fa-city"></i>',
    '🌴' => '<i class="fas fa-tree"></i>',
    '⛰️' => '<i class="fas fa-mountain"></i>',
    '🌊' => '<i class="fas fa-water"></i>',
    '🌿' => '<i class="fas fa-leaf"></i>',
    '🌾' => '<i class="fas fa-wheat-awn"></i>',
    '🏝️' => '<i class="fas fa-island"></i>',
    '🏖️' => '<i class="fas fa-umbrella-beach"></i>',
    '🎿' => '<i class="fas fa-person-skiing"></i>',
    '♨️' => '<i class="fas fa-hot-tub"></i>',
    '🏞️' => '<i class="fas fa-mountain-sun"></i>',
    '🎪' => '<i class="fas fa-ticket"></i>',
    '🏰' => '<i class="fas fa-church"></i>',
    '🍽️' => '<i class="fas fa-utensils"></i>',
    '🎉' => '<i class="fas fa-calendar-days"></i>',
    '🏨' => '<i class="fas fa-hotel"></i>',
    '🎡' => '<i class="fas fa-ferris-wheel"></i>',
    '📍' => '<i class="fas fa-location-dot"></i>',
    '🚗' => '<i class="fas fa-car"></i>',
    '✈️' => '<i class="fas fa-plane"></i>',
    '🌍' => '<i class="fas fa-globe"></i>',
    '📱' => '<i class="fas fa-mobile-screen"></i>',
    '💼' => '<i class="fas fa-briefcase"></i>',
    '📊' => '<i class="fas fa-chart-line"></i>',
    '⚡' => '<i class="fas fa-bolt"></i>',
    '🔒' => '<i class="fas fa-lock"></i>',
    '👤' => '<i class="fas fa-user"></i>',
    '👥' => '<i class="fas fa-users"></i>',
    '⚙️' => '<i class="fas fa-gear"></i>',
    '🔔' => '<i class="fas fa-bell"></i>',
    '🎯' => '<i class="fas fa-bullseye"></i>',
    '📈' => '<i class="fas fa-chart-line"></i>',
    '🏆' => '<i class="fas fa-trophy"></i>',
    '🔍' => '<i class="fas fa-magnifying-glass"></i>',
    '📝' => '<i class="fas fa-pen"></i>',
    '🗑️' => '<i class="fas fa-trash"></i>',
    '✏️' => '<i class="fas fa-pencil"></i>',
    '➕' => '<i class="fas fa-plus"></i>',
    '✅' => '<i class="fas fa-check"></i>',
    '❌' => '<i class="fas fa-xmark"></i>',
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'blade.php') {
        $content = file_get_contents($file->getPathname());
        $newContent = $content;
        
        foreach ($replacements as $emoji => $icon) {
            $newContent = str_replace($emoji, $icon, $newContent);
        }
        
        if ($content !== $newContent) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getPathname() . "\n";
        }
    }
}

echo "Emoji replacement completed.\n";
