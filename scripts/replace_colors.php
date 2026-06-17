<?php
$directory = __DIR__ . '/../resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

$replacements = [
    // Rosa/rosado a azul corporativo
    '#ec4899' => '#2563eb',
    '#db2777' => '#1d4ed8',
    '#f093fb' => '#3b82f6',
    '#f5576c' => '#0ea5e9',
    '#fa709a' => '#64748b',
    
    // Verde brillante a verde corporativo
    '#10b981' => '#059669',
    '#4facfe' => '#3b82f6',
    '#00f2fe' => '#0ea5e9',
    
    // Amarillo brillante a ámbar corporativo
    '#fee140' => '#f59e0b',
    
    // Púrpura a azul oscuro
    '#667eea' => '#2563eb',
    '#764ba2' => '#1d4ed8',
    '#6366f1' => '#2563eb',
    '#8b5cf6' => '#1d4ed8',
    '#818cf8' => '#3b82f6',
    
    // Naranja brillante a naranja corporativo
    '#f97316' => '#ea580c',
    
    // Cian brillante a azul cielo corporativo
    '#30cfd0' => '#0ea5e9',
    '#330867' => '#1d4ed8',
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'blade.php') {
        $content = file_get_contents($file->getPathname());
        $newContent = $content;
        
        foreach ($replacements as $oldColor => $newColor) {
            $newContent = str_replace($oldColor, $newColor, $newContent);
        }
        
        if ($content !== $newContent) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getPathname() . "\n";
        }
    }
}

echo "Color replacement completed.\n";
