<?php

namespace App\Services;

use App\Models\Imagen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageResolver
{
    /**
     * Obtiene imagen por nombre exacto o normalizado
     * 
     * @param string $name - Nombre a buscar (ej: "Cartagena", "Medellín", "Barranquilla")
     * @param string|null $category - Categoría opcional para filtrar
     * @return string|null - URL de la imagen o null
     */
    public static function forName(string $name, ?string $category = null): ?string
    {
        $normalizedName = self::normalizeText($name);
        
        Log::info('Buscando imagen por nombre', [
            'original' => $name,
            'normalized' => $normalizedName,
            'category' => $category,
        ]);

        // Intentar búsqueda exacta primero
        $imagen = Imagen::where('NOMBRE_IMAGEN', $name)
            ->when($category, function($q) use ($category) {
                return $q->where('categoria', $category);
            })
            ->first();

        if ($imagen) {
            Log::info('Imagen encontrada (exacta)', [
                'nombre_imagen' => $imagen->NOMBRE_IMAGEN,
                'ruta' => $imagen->RUTA,
            ]);
            return self::toPublicUrl($imagen);
        }

        // Intentar búsqueda por nombre normalizado (sin tildes, minúsculas)
        $imagenes = Imagen::all();
        foreach ($imagenes as $img) {
            $imgNormalized = self::normalizeText($img->NOMBRE_IMAGEN ?? '');
            
            if ($imgNormalized === $normalizedName) {
                // Verificar categoría si se especificó
                if ($category && $img->categoria !== $category) {
                    continue;
                }
                
                Log::info('Imagen encontrada (normalizada)', [
                    'nombre_imagen' => $img->NOMBRE_IMAGEN,
                    'normalized' => $imgNormalized,
                    'ruta' => $img->RUTA,
                ]);
                return self::toPublicUrl($img);
            }
        }

        // Intentar búsqueda parcial (para nombres compuestos)
        // Ej: "Cartagena de Indias" debe encontrar "Cartagena"
        $parts = explode(' ', $normalizedName);
        foreach ($parts as $part) {
            if (strlen($part) >= 4) { // Solo buscar partes significativas
                foreach ($imagenes as $img) {
                    $imgNormalized = self::normalizeText($img->NOMBRE_IMAGEN ?? '');
                    if (str_contains($imgNormalized, $part) || str_contains($part, $imgNormalized)) {
                        if ($category && $img->categoria !== $category) {
                            continue;
                        }
                        
                        Log::info('Imagen encontrada (parcial)', [
                            'nombre_imagen' => $img->NOMBRE_IMAGEN,
                            'partial_match' => $part,
                            'ruta' => $img->RUTA,
                        ]);
                        return self::toPublicUrl($img);
                    }
                }
            }
        }

        Log::warning('No se encontró imagen para nombre', [
            'name' => $name,
            'normalized' => $normalizedName,
            'category' => $category,
        ]);

        return null;
    }

    /**
     * Normaliza texto para comparación (sin tildes, minúsculas, sin espacios extra)
     * 
     * @param string $text
     * @return string
     */
    private static function normalizeText(string $text): string
    {
        return Str::of($text)
            ->lower()
            ->ascii()
            ->trim()
            ->replaceMatches('/\s+/', ' ')
            ->toString();
    }
    /**
     * Obtiene la imagen de portada para una entidad
     * 
     * @param Model $entity - Entidad (municipio, departamento, evento, etc.)
     * @param string|null $category - Categoría opcional (paisajes, cultura, gastronomia, naturaleza, eventos)
     * @return string|null - URL de la imagen o null si no existe
     */
    public static function coverFor(Model $entity, ?string $category = null): ?string
    {
        // La tabla_imagenes solo tiene: ID_IMAGEN, NOMBRE_IMAGEN, RUTA
        // No tiene relaciones polimórficas, así que buscamos por nombre
        $nombre = self::getEntityName($entity);
        
        if (!$nombre) {
            return null;
        }

        // Buscar por nombre exacto
        $imagen = Imagen::where('NOMBRE_IMAGEN', $nombre)->first();
        
        if ($imagen) {
            return self::toPublicUrl($imagen);
        }
        
        // Buscar por nombre normalizado
        $imagenes = Imagen::all();
        $normalizedName = self::normalizeText($nombre);
        
        foreach ($imagenes as $img) {
            $imgNormalized = self::normalizeText($img->NOMBRE_IMAGEN ?? '');
            
            if ($imgNormalized === $normalizedName) {
                return self::toPublicUrl($img);
            }
        }
        
        // Si no hay imagen específica, buscar imagen del padre si aplica
        if (method_exists($entity, 'departamento') && $entity->departamento) {
            return self::coverFor($entity->departamento, $category);
        }
        
        if (method_exists($entity, 'municipio') && $entity->municipio) {
            return self::coverFor($entity->municipio, $category);
        }
        
        return null;
    }

    /**
     * Obtiene una galería de imágenes para una entidad
     * 
     * @param Model $entity - Entidad
     * @param string|null $category - Categoría opcional
     * @param int $limit - Límite de imágenes
     * @return array - Array de URLs de imágenes
     */
    public static function galleryFor(Model $entity, ?string $category = null, int $limit = 5): array
    {
        // La tabla_imagenes solo tiene: ID_IMAGEN, NOMBRE_IMAGEN, RUTA
        // No tiene relaciones polimórficas, así que buscamos por nombre
        $nombre = self::getEntityName($entity);
        
        if (!$nombre) {
            return [];
        }

        // Buscar por nombre exacto
        $imagen = Imagen::where('NOMBRE_IMAGEN', $nombre)->first();
        
        if ($imagen) {
            return [self::toPublicUrl($imagen)];
        }
        
        // Buscar por nombre normalizado
        $imagenes = Imagen::all();
        $normalizedName = self::normalizeText($nombre);
        
        foreach ($imagenes as $img) {
            $imgNormalized = self::normalizeText($img->NOMBRE_IMAGEN ?? '');
            
            if ($imgNormalized === $normalizedName) {
                return [self::toPublicUrl($img)];
            }
        }
        
        return [];
    }

    /**
     * Obtiene imagen para un item específico (plato, deporte, evento, etc.)
     * 
     * @param Model $item - Item específico
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forItem(Model $item, ?string $category = null): ?string
    {
        return self::coverFor($item, $category);
    }

    /**
     * Obtiene imagen para una región
     * 
     * @param Model $region - Región
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forRegion(Model $region, ?string $category = null): ?string
    {
        return self::coverFor($region, $category);
    }

    /**
     * Obtiene imagen para una ruta
     * 
     * @param Model $route - Ruta
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forRoute(Model $route, ?string $category = null): ?string
    {
        return self::coverFor($route, $category);
    }

    /**
     * Obtiene imagen para un deporte de aventura
     * 
     * @param Model $sport - Deporte/actividad
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forAdventureSport(Model $sport, ?string $category = null): ?string
    {
        return self::coverFor($sport, $category);
    }

    /**
     * Obtiene imagen para un evento
     *
     * @param Model $event - Evento
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forEvent(Model $event, ?string $category = null): ?string
    {
        return self::coverFor($event, $category);
    }

    /**
     * Obtiene imagen para una feria/fiesta desde tabla_ferias
     *
     * @param object $feria - Objeto de feria (puede ser modelo o stdClass)
     * @param array &$usedImages - Array de IDs de imágenes ya usadas (por referencia)
     * @param \Illuminate\Support\Collection|null $imagenesMap - Mapa de imágenes pre-cargadas (opcional)
     * @return array - Array con ['url' => string|null, 'id' => string|null, 'match_type' => string]
     */
    public static function forFeria(object $feria, array &$usedImages = [], $imagenesMap = null): array
    {
        $nombre = $feria->NOMBRE_FERIAS_Y_FIESTAS ?? $feria->nombre ?? null;
        $id = $feria->ID_FIESTA ?? $feria->id ?? null;

        if (!$nombre) {
            Log::warning('Feria sin nombre para resolver imagen', ['feria' => $feria]);
            return ['url' => null, 'id' => null, 'match_type' => 'fallback'];
        }

        $normalizedName = self::normalizeText($nombre);

        Log::info('Resolviendo imagen para feria', [
            'feria' => $nombre,
            'id' => $id,
            'normalized' => $normalizedName,
        ]);

        // Usar imágenes pre-cargadas si se proporcionan, sino cargarlas
        if ($imagenesMap === null) {
            $imagenesMap = \App\Models\Imagen::whereNotIn('ID_IMAGEN', $usedImages)->get();
        }

        // 1. Coincidencia exacta por NOMBRE_IMAGEN
        $imagen = $imagenesMap->firstWhere('NOMBRE_IMAGEN', $nombre);

        if ($imagen && !in_array($imagen->ID_IMAGEN, $usedImages)) {
            $usedImages[] = $imagen->ID_IMAGEN;
            Log::info('Imagen encontrada (coincidencia exacta)', [
                'feria' => $nombre,
                'imagen' => $imagen->NOMBRE_IMAGEN,
                'ruta' => $imagen->RUTA,
            ]);
            return [
                'url' => self::toPublicUrl($imagen),
                'id' => $imagen->ID_IMAGEN,
                'match_type' => 'exact'
            ];
        }

        // 2. Coincidencia normalizada
        foreach ($imagenesMap as $img) {
            if (in_array($img->ID_IMAGEN, $usedImages)) {
                continue;
            }
            
            $imgNormalized = self::normalizeText($img->NOMBRE_IMAGEN ?? '');

            if ($imgNormalized === $normalizedName) {
                $usedImages[] = $img->ID_IMAGEN;
                Log::info('Imagen encontrada (normalizada)', [
                    'feria' => $nombre,
                    'imagen' => $img->NOMBRE_IMAGEN,
                    'normalized' => $imgNormalized,
                    'ruta' => $img->RUTA,
                ]);
                return [
                    'url' => self::toPublicUrl($img),
                    'id' => $img->ID_IMAGEN,
                    'match_type' => 'normalized'
                ];
            }
        }

        // 3. Coincidencia por palabras clave fuertes
        $palabrasClave = ['flores', 'carnaval', 'wayuu', 'cali', 'manizales', 'barranquilla', 'salsa', 'teatro', 'feria', 'festival', 'fiesta', 'negros', 'blancos'];

        foreach ($palabrasClave as $palabra) {
            if (str_contains($normalizedName, $palabra)) {
                foreach ($imagenesMap as $img) {
                    if (in_array($img->ID_IMAGEN, $usedImages)) {
                        continue;
                    }
                    
                    $imgNormalized = self::normalizeText($img->NOMBRE_IMAGEN ?? '');
                    if (str_contains($imgNormalized, $palabra)) {
                        $usedImages[] = $img->ID_IMAGEN;
                        Log::info('Imagen encontrada (palabra clave)', [
                            'feria' => $nombre,
                            'imagen' => $img->NOMBRE_IMAGEN,
                            'palabra' => $palabra,
                            'ruta' => $img->RUTA,
                        ]);
                        return [
                            'url' => self::toPublicUrl($img),
                            'id' => $img->ID_IMAGEN,
                            'match_type' => 'keyword'
                        ];
                    }
                }
            }
        }

        Log::warning('Feria sin imagen relacionada', [
            'feria' => $nombre,
            'normalized' => $normalizedName,
        ]);

        return ['url' => null, 'id' => null, 'match_type' => 'fallback'];
    }

    /**
     * Obtiene imagen para gastronomía
     * 
     * @param Model $gastronomy - Plato/producto gastronómico
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forGastronomy(Model $gastronomy, ?string $category = null): ?string
    {
        return self::coverFor($gastronomy, $category ?? 'gastronomia');
    }

    /**
     * Obtiene imagen para un municipio
     * 
     * @param Model $municipio - Municipio
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forMunicipio(Model $municipio, ?string $category = null): ?string
    {
        return self::coverFor($municipio, $category);
    }

    /**
     * Obtiene imagen para un departamento
     * 
     * @param Model $departamento - Departamento
     * @param string|null $category - Categoría opcional
     * @return string|null - URL de la imagen o null
     */
    public static function forDepartamento(Model $departamento, ?string $category = null): ?string
    {
        return self::coverFor($departamento, $category);
    }

    /**
     * Verifica si una entidad tiene imagen
     * 
     * @param Model $entity - Entidad
     * @param string|null $category - Categoría opcional
     * @return bool - True si tiene imagen
     */
    public static function hasImage(Model $entity, ?string $category = null): bool
    {
        return self::coverFor($entity, $category) !== null;
    }

    /**
     * Convierte un registro de imagen a URL pública
     * 
     * @param Imagen $imagen - Registro de imagen
     * @return string|null - URL pública o null
     */
    private static function toPublicUrl($imagen): ?string
    {
        if (!$imagen) {
            return null;
        }

        $path = $imagen->RUTA ?? null;
        
        if (!$path) {
            return null;
        }

        // Si ya es una URL completa (http/https), retornarla tal cual
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Si es una ruta relativa, convertirla a asset
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        // Por defecto, tratar como storage
        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * Obtiene el nombre de una entidad para búsqueda
     * 
     * @param Model $entity - Entidad
     * @return string|null - Nombre normalizado
     */
    private static function getEntityName(Model $entity): ?string
    {
        // Intentar diferentes propiedades de nombre
        $name = $entity->nombre 
            ?? $entity->NOMBRE 
            ?? $entity->name 
            ?? $entity->NOMBRE_MUNICIPIOS 
            ?? $entity->NOMBRE_DEPARTAMENTO 
            ?? $entity->NOMBRE_DEPORTES_AVENTURA 
            ?? $entity->NOMBRE_PLATO 
            ?? $entity->NOMBRE_IGLESIA 
            ?? $entity->NOMBRE_PARQUES_TEMÁTICOS 
            ?? $entity->NOMBRE_PLAYA 
            ?? $entity->NOMBRE_RESERVAS_O_PARQUES 
            ?? $entity->NOMBRE_TERMAL 
            ?? $entity->NOMBRE_ACTIVIDAD_EN_PARQUE 
            ?? null;

        if ($name) {
            return self::normalizeText($name);
        }

        return null;
    }
}
