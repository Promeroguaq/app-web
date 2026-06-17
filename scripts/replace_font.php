<?php
$directory = __DIR__ . '/../resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'blade.php') {
        $content = file_get_contents($file->getPathname());
        $newContent = str_replace("Space Grotesk", "Inter", $content);
        
        if ($content !== $newContent) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Updated: " . $file->getPathname() . "\n";
        }
    }
}

echo "Font replacement completed.\n";
