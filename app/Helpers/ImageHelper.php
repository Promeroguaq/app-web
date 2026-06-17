<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Busca una imagen en tabla_imagenes por coincidencia de nombre
     * 
     * @param string $searchTerm - Término a buscar (nombre de departamento, municipio, etc.)
     * @param string $category - Categoría opcional para filtrar (turismo_naturaleza, turismo_cultural, etc.)
     * @param array $excludeImages - Array de URLs de imágenes a excluir (para evitar repeticiones)
     * @return string|null - URL de la imagen o null si no encuentra
     */
    public static function findImageByName($searchTerm, $category = null, $excludeImages = [])
    {
        if (empty($searchTerm)) {
            return null;
        }

        // Limpiar el término de búsqueda
        $searchTerm = self::cleanString($searchTerm);
        
        // Buscar en tabla_imagenes
        $query = \DB::table('tabla_imagenes');
        
        // Si se especifica categoría, filtrar por ruta que contenga la categoría
        if ($category) {
            $query->where('RUTA', 'like', "%{$category}%");
        }
        
        // Excluir imágenes ya usadas
        if (!empty($excludeImages)) {
            $query->whereNotIn('RUTA', $excludeImages);
        }
        
        $imagenes = $query->limit(100)->get();
        
        $bestMatch = null;
        $bestScore = 0;
        
        foreach ($imagenes as $imagen) {
            $nombreImagen = self::cleanString($imagen->NOMBRE_IMAGEN);
            
            // Coincidencia exacta
            if (strcasecmp($nombreImagen, $searchTerm) === 0) {
                return $imagen->RUTA;
            }
            
            // Coincidencia parcial
            if (stripos($nombreImagen, $searchTerm) !== false || stripos($searchTerm, $nombreImagen) !== false) {
                $score = similar_text($nombreImagen, $searchTerm, $percent);
                if ($percent > $bestScore) {
                    $bestScore = $percent;
                    $bestMatch = $imagen->RUTA;
                }
            }
        }
        
        // Si encontramos una coincidencia con buen score (> 50%)
        if ($bestScore > 50) {
            return $bestMatch;
        }
        
        return null;
    }
    
    /**
     * Obtiene una imagen por categoría específica (no aleatoria)
     * 
     * @param string $category - Categoría (turismo_naturaleza, turismo_cultural, etc.)
     * @param array $excludeImages - Array de URLs de imágenes a excluir (para evitar repeticiones)
     * @return string|null - URL de la imagen o null
     */
    public static function getImageByCategory($category, $excludeImages = [])
    {
        $query = \DB::table('tabla_imagenes')
            ->where('RUTA', 'like', "%{$category}%");
        
        // Excluir imágenes ya usadas
        if (!empty($excludeImages)) {
            $query->whereNotIn('RUTA', $excludeImages);
        }
        
        // Usar orden en lugar de random
        $imagen = $query->orderBy('ID_IMAGEN')->first();
        
        return $imagen ? $imagen->RUTA : null;
    }
    
    /**
     * Obtiene una imagen para un departamento específico
     * 
     * @param string $departamentoNombre - Nombre del departamento
     * @return string|null - URL de la imagen o null
     */
    public static function getDepartamentoImage($departamentoNombre)
    {
        // Primero buscar por nombre exacto o parcial
        $imagen = self::findImageByName($departamentoNombre);
        
        if ($imagen) {
            return $imagen;
        }
        
        // Si no encuentra, buscar en turismo cultural o naturaleza
        $imagen = self::findImageByName($departamentoNombre, 'turismo_cultural');
        if ($imagen) return $imagen;
        
        $imagen = self::findImageByName($departamentoNombre, 'turismo_naturaleza');
        if ($imagen) return $imagen;
        
        // Retornar null si no hay imagen
        return null;
    }
    
    /**
     * Obtiene una imagen para un municipio específico
     * 
     * @param string $municipioNombre - Nombre del municipio
     * @param string $departamentoNombre - Nombre del departamento (opcional)
     * @param \Illuminate\Support\Collection $imagenesPorNombre - Índice de imágenes por nombre normalizado (opcional)
     * @return string|null - URL de la imagen o null
     */
    public static function getMunicipioImage($municipioNombre, $departamentoNombre = null, $imagenesPorNombre = null)
    {
        if (empty($municipioNombre)) {
            return null;
        }
        
        // Normalizar nombre del municipio para búsqueda
        $nombreNormalizado = self::cleanString($municipioNombre);
        
        // 1. Buscar coincidencia exacta por nombre normalizado
        if ($imagenesPorNombre && isset($imagenesPorNombre[$nombreNormalizado])) {
            \Log::info('Imagen municipio encontrada (exacta)', [
                'municipio' => $municipioNombre,
                'nombre_normalizado' => $nombreNormalizado,
                'imagen_nombre' => $imagenesPorNombre[$nombreNormalizado]->NOMBRE_IMAGEN ?? null
            ]);
            return $imagenesPorNombre[$nombreNormalizado]->RUTA;
        }
        
        // 2. Si no se proporcionó índice, buscar en BD (fallback para compatibilidad)
        if (!$imagenesPorNombre) {
            $imagen = self::findImageByName($municipioNombre);
            if ($imagen) {
                \Log::info('Imagen municipio encontrada (BD)', [
                    'municipio' => $municipioNombre
                ]);
                return $imagen;
            }
        }
        
        // 3. Para nombres compuestos, intentar coincidencia parcial segura
        // Ejemplo: "Cartagena de Indias" -> intentar "Cartagena"
        $palabras = explode(' ', $nombreNormalizado);
        if (count($palabras) > 1) {
            $nombreCorto = $palabras[0]; // Primera palabra
            if (strlen($nombreCorto) >= 4 && $imagenesPorNombre && isset($imagenesPorNombre[$nombreCorto])) {
                \Log::info('Imagen municipio encontrada (parcial)', [
                    'municipio' => $municipioNombre,
                    'nombre_corto' => $nombreCorto,
                    'imagen_nombre' => $imagenesPorNombre[$nombreCorto]->NOMBRE_IMAGEN ?? null
                ]);
                return $imagenesPorNombre[$nombreCorto]->RUTA;
            }
        }
        
        // 4. Log de advertencia si no se encuentra imagen
        \Log::warning('Municipio sin imagen específica', [
            'municipio' => $municipioNombre,
            'departamento' => $departamentoNombre,
            'nombre_normalizado' => $nombreNormalizado
        ]);
        
        // 5. Retornar null - NO usar imagen del departamento como fallback
        // para evitar que todos los municipios del mismo departamento tengan la misma imagen
        return null;
    }
    
    /**
     * Obtiene una imagen para una categoría específica (playas, museos, etc.)
     * 
     * @param string $categoria - Nombre de la categoría
     * @param string $nombre - Nombre específico del item
     * @return string|null - URL de la imagen o null
     */
    public static function getCategoriaImage($categoria, $nombre = null)
    {
        // Mapeo de categorías a rutas de imágenes
        $categoryMap = [
            'playas' => 'playas',
            'museos' => 'turismo_cultural',
            'iglesias' => 'turismo_cultural',
            'gastronomia' => 'gastronomia',
            'termales' => 'turismo_naturaleza',
            'reservas' => 'turismo_naturaleza',
            'parque_tematicos' => 'turismo_cultural',
            'deporte_aventura' => 'deportes_aventura',
            'desierto_laguna' => 'turismo_naturaleza',
            'ferias' => 'turismo_cultural',
            'ciclismo' => 'deportes_aventura',
            'actividad_parque' => 'actividades_en_parques',
            'islas' => 'turismo_naturaleza',
        ];
        
        $imageCategory = $categoryMap[$categoria] ?? 'turismo_naturaleza';
        
        // Si hay nombre específico, buscarlo
        if ($nombre) {
            $imagen = self::findImageByName($nombre, $imageCategory);
            if ($imagen) return $imagen;
            
            // Para actividades en parques, intentar búsqueda por palabras clave
            if ($categoria === 'actividad_parque') {
                $imagen = self::findActividadParqueImage($nombre);
                if ($imagen) return $imagen;
            }
        }
        
        // Retornar null si no hay imagen - NO usar imagen por categoría genérica
        return null;
    }
    
    /**
     * Búsqueda especializada para imágenes de actividades en parques
     * Busca por coincidencia de palabras clave en el nombre
     * 
     * @param string $nombre - Nombre de la actividad
     * @return string|null - URL de la imagen o null
     */
    private static function findActividadParqueImage($nombre)
    {
        if (empty($nombre)) {
            return null;
        }
        
        $nombreNormalizado = self::cleanString($nombre);
        
        // Palabras clave comunes para buscar
        $palabrasClave = self::extractKeywords($nombreNormalizado);
        
        if (empty($palabrasClave)) {
            return null;
        }
        
        // Buscar imágenes en actividades_en_parques
        $imagenes = \DB::table('tabla_imagenes')
            ->where('RUTA', 'like', '%actividades_en_parques%')
            ->get();
        
        foreach ($imagenes as $imagen) {
            $nombreImagenNormalizado = self::cleanString($imagen->NOMBRE_IMAGEN);
            
            // Verificar coincidencia por palabras clave
            foreach ($palabrasClave as $palabra) {
                if (strlen($palabra) >= 4 && (stripos($nombreImagenNormalizado, $palabra) !== false)) {
                    return $imagen->RUTA;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Extrae palabras clave de un nombre normalizado
     * 
     * @param string $texto - Texto normalizado
     * @return array - Array de palabras clave
     */
    private static function extractKeywords($texto)
    {
        // Palabras a ignorar
        $stopWords = ['de', 'la', 'el', 'en', 'y', 'o', 'a', 'para', 'por', 'con', 'sin', 'los', 'las', 'un', 'una', 'actividad', 'observacion', 'observación'];
        
        $palabras = explode(' ', $texto);
        $keywords = [];
        
        foreach ($palabras as $palabra) {
            $palabra = trim($palabra);
            if (strlen($palabra) >= 3 && !in_array($palabra, $stopWords)) {
                $keywords[] = $palabra;
            }
        }
        
        return $keywords;
    }
    
    /**
     * Limpia una cadena para comparación
     *
     * @param string $string
     * @return string
     */
    public static function cleanString($string)
    {
        // Eliminar acentos
        $string = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N'],
            $string
        );

        // Eliminar caracteres especiales y espacios extra
        $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
        $string = trim($string);

        return strtolower($string);
    }
    
    /**
     * Obtiene una imagen para una experiencia específica
     * 
     * @param string $categoria - Categoría de la experiencia (paisajes, cultura, gastronomia, naturaleza, eventos)
     * @param string $type - Tipo de experiencia específico (miradores, caminatas, fotografia, etc.)
     * @return string|null - URL de la imagen o null si no encuentra
     */
    public static function getExperienceImage($categoria, $type = null)
    {
        $searchTerms = [];
        
        // Agregar términos de búsqueda basados en el tipo
        if (!empty($type)) {
            $searchTerms[] = $type;
            $searchTerms[] = str_replace('-', ' ', $type);
            $searchTerms[] = str_replace('_', ' ', $type);
        }
        
        // Agregar términos de búsqueda basados en la categoría
        if (!empty($categoria)) {
            $searchTerms[] = $categoria;
            $searchTerms[] = str_replace('-', ' ', $categoria);
            $searchTerms[] = str_replace('_', ' ', $categoria);
        }
        
        // Mapa de palabras clave por categoría
        $keywordMap = [
            'paisajes' => ['paisaje', 'mirador', 'atardecer', 'montaña', 'naturaleza'],
            'cultura' => ['cultura', 'museo', 'arquitectura', 'tradicion', 'historia'],
            'gastronomia' => ['gastronomia', 'comida', 'plato', 'restaurante', 'cafe'],
            'naturaleza' => ['naturaleza', 'parque', 'rio', 'fauna', 'flora', 'sendero'],
            'eventos' => ['evento', 'feria', 'festival', 'fiesta', 'carnaval'],
        ];
        
        $categoriaNormalizada = self::cleanString($categoria);
        
        if (isset($keywordMap[$categoriaNormalizada])) {
            $searchTerms = array_merge($searchTerms, $keywordMap[$categoriaNormalizada]);
        }
        
        // Buscar imágenes en tabla_imagenes
        $imagenes = \DB::table('tabla_imagenes')
            ->select('NOMBRE_IMAGEN', 'RUTA')
            ->whereNotNull('RUTA')
            ->get();
        
        foreach ($searchTerms as $term) {
            $normalizedTerm = self::cleanString($term);
            
            $match = $imagenes->first(function ($image) use ($normalizedTerm) {
                $imageName = self::cleanString($image->NOMBRE_IMAGEN ?? '');
                
                return $imageName === $normalizedTerm
                    || str_contains($imageName, $normalizedTerm)
                    || str_contains($normalizedTerm, $imageName);
            });
            
            if ($match && !empty($match->RUTA)) {
                return $match->RUTA;
            }
        }
        
        // Retornar null si no encuentra imagen - NO usar fallback aleatorio
        return null;
    }
    
    /**
     * Método temporal de compatibilidad para evitar errores
     * Devuelve null para forzar el uso de fallback premium
     * 
     * @deprecated Este método será eliminado cuando se limpien todas las llamadas
     */
    public static function getRandomImageByCategory($category = null, $excluded = [])
    {
        return null;
    }
    
    /**
     * Genera etiquetas dinámicas para una actividad basadas en su nombre
     *
     * @param string $nombre - Nombre de la actividad
     * @return array - Array de etiquetas (máximo 2)
     */
    public static function getActivityTags($nombre)
    {
        if (empty($nombre)) {
            return ['Actividad'];
        }
        
        $nombreLower = self::cleanString($nombre);
        $tags = [];
        
        // Mapeo de palabras clave a etiquetas
        $keywordMap = [
            'ballena' => ['Avistamiento', 'Fauna marina'],
            'ballenas' => ['Avistamiento', 'Fauna marina'],
            'fauna' => ['Biodiversidad', 'Ecoturismo'],
            'flora' => ['Biodiversidad', 'Ecoturismo'],
            'geologica' => ['Geología', 'Paisaje natural'],
            'geológica' => ['Geología', 'Paisaje natural'],
            'fotografia' => ['Fotografía', 'Paisaje'],
            'fotografía' => ['Fotografía', 'Paisaje'],
            'video' => ['Contenido visual', 'Paisaje'],
            'mariposa' => ['Biodiversidad', 'Insectos'],
            'mariposas' => ['Biodiversidad', 'Insectos'],
            'insecto' => ['Biodiversidad', 'Insectos'],
            'insectos' => ['Biodiversidad', 'Insectos'],
            'escalada' => ['Escalada', 'Aventura'],
            'roca' => ['Aventura', 'Paisaje'],
            'aves' => ['Observación', 'Aves'],
            'pajaro' => ['Observación', 'Aves'],
            'pájaro' => ['Observación', 'Aves'],
            'caminata' => ['Senderismo', 'Aventura'],
            'senderismo' => ['Senderismo', 'Aventura'],
            'cabalgata' => ['Cabalgata', 'Aventura'],
            'kayak' => ['Acuática', 'Aventura'],
            'natacion' => ['Acuática', 'Deporte'],
            'natación' => ['Acuática', 'Deporte'],
            'buceo' => ['Acuática', 'Aventura'],
            'observacion' => ['Observación', 'Naturaleza'],
            'observación' => ['Observación', 'Naturaleza'],
        ];
        
        // Buscar coincidencias en el nombre
        foreach ($keywordMap as $keyword => $tagPair) {
            if (strpos($nombreLower, $keyword) !== false) {
                $tags = array_merge($tags, $tagPair);
                if (count($tags) >= 2) {
                    break;
                }
            }
        }
        
        // Eliminar duplicados y limitar a 2
        $tags = array_unique($tags);
        $tags = array_slice($tags, 0, 2);
        
        // Fallback si no se encontraron etiquetas
        if (empty($tags)) {
            $tags = ['Actividad'];
        }
        
        return $tags;
    }

    /**
     * Obtiene una imagen para un plato típico de gastronomía
     * 
     * @param string $platoNombre - Nombre del plato
     * @param string $departamento - Nombre del departamento (opcional, SOLO para logs)
     * @param string $categoria - Categoría gastronómica (opcional, SOLO para logs)
     * @param array $usedImages - Array de rutas de imágenes ya usadas (opcional)
     * @param array $imagenesMap - Mapa de imágenes pre-cargado (opcional)
     * @return array - Array con 'url', 'id', 'match_type'
     */
    public static function getGastronomiaImage($platoNombre, $departamento = null, $categoria = null, $usedImages = [], $imagenesMap = null)
    {
        $result = [
            'url' => null,
            'id' => null,
            'match_type' => 'none'
        ];

        if (empty($platoNombre)) {
            return $result;
        }

        // Normalizar nombre del plato
        $nombreNormalizado = self::cleanString($platoNombre);

        // Cargar mapa de imágenes (usando caché si se proporciona, o cargando desde BD)
        if ($imagenesMap === null) {
            $imagenesMap = self::getImagenesMap($usedImages);
        }

        // 1. Buscar coincidencia exacta en tabla_imagenes
        $imagenExacta = $imagenesMap->firstWhere('NOMBRE_IMAGEN', $platoNombre);

        if ($imagenExacta) {
            $result['url'] = $imagenExacta->RUTA;
            $result['id'] = $imagenExacta->ID_IMAGEN;
            $result['match_type'] = 'exact';
            return $result;
        }

        // 2. Buscar coincidencia normalizada
        foreach ($imagenesMap as $imagen) {
            $nombreImagenNormalizado = self::cleanString($imagen->NOMBRE_IMAGEN);

            if ($nombreImagenNormalizado === $nombreNormalizado) {
                $result['url'] = $imagen->RUTA;
                $result['id'] = $imagen->ID_IMAGEN;
                $result['match_type'] = 'normalized';
                return $result;
            }
        }

        // 3. Buscar coincidencia parcial por palabras clave (solo palabras >= 4 caracteres)
        $palabrasClave = self::extractKeywords($nombreNormalizado);

        if (!empty($palabrasClave)) {
            foreach ($imagenesMap as $imagen) {
                $nombreImagenNormalizado = self::cleanString($imagen->NOMBRE_IMAGEN);

                foreach ($palabrasClave as $palabra) {
                    if (strlen($palabra) >= 4 && stripos($nombreImagenNormalizado, $palabra) !== false) {
                        $result['url'] = $imagen->RUTA;
                        $result['id'] = $imagen->ID_IMAGEN;
                        $result['match_type'] = 'keyword';
                        return $result;
                    }
                }
            }
        }

        // 4. Buscar coincidencia por nombre contenido (el nombre del plato está contenido en la imagen)
        foreach ($imagenesMap as $imagen) {
            $nombreImagenNormalizado = self::cleanString($imagen->NOMBRE_IMAGEN);

            // Solo si el nombre del plato está claramente contenido en el nombre de la imagen
            if (stripos($nombreImagenNormalizado, $nombreNormalizado) !== false && strlen($nombreImagenNormalizado) > strlen($nombreNormalizado)) {
                $result['url'] = $imagen->RUTA;
                $result['id'] = $imagen->ID_IMAGEN;
                $result['match_type'] = 'contains';
                return $result;
            }
        }

        // Retornar null si no encuentra imagen específica del plato (fallback premium en la vista)
        // NO usar departamento o categoría como fallback para platos
        return $result;
    }

    /**
     * Obtiene el mapa de imágenes desde caché o base de datos
     * 
     * @param array $usedImages - Array de rutas de imágenes ya usadas
     * @return Collection - Colección de imágenes
     */
    private static function getImagenesMap($usedImages = [])
    {
        // Intentar obtener desde caché (30 minutos)
        $cacheKey = 'imagenes_gastronomia_map_' . md5(implode(',', $usedImages));
        
        return \Cache::remember($cacheKey, 1800, function () use ($usedImages) {
            $query = \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA');

            if (!empty($usedImages)) {
                $query->whereNotIn('RUTA', $usedImages);
            }

            return $query->get();
        });
    }

    /**
     * Obtiene una imagen para una reserva/parque
     * 
     * @param string $nombre - Nombre de la reserva/parque
     * @param array $usedImages - Array de rutas de imágenes ya usadas
     * @param array $imagenesMap - Mapa de imágenes pre-cargado
     * @return array - Array con 'url', 'id', 'match_type'
     */
    public static function getReservaParqueImage($nombre, $usedImages = [], $imagenesMap = null)
    {
        $result = [
            'url' => null,
            'id' => null,
            'match_type' => 'none'
        ];

        if (empty($nombre)) {
            return $result;
        }

        // Normalizar nombre
        $nombreNormalizado = self::cleanString($nombre);

        // Usar mapa proporcionado o cargar uno nuevo
        if ($imagenesMap === null) {
            $imagenesMap = \DB::table('tabla_imagenes')
                ->select('ID_IMAGEN', 'NOMBRE_IMAGEN', 'RUTA')
                ->get();
        }

        // Filtrar imágenes ya usadas para evitar repeticiones
        if (!empty($usedImages)) {
            $imagenesMap = $imagenesMap->filter(function($imagen) use ($usedImages) {
                return !in_array($imagen->RUTA, $usedImages);
            });
        }

        // 1. Buscar coincidencia exacta
        $imagenExacta = $imagenesMap->firstWhere('NOMBRE_IMAGEN', $nombre);

        if ($imagenExacta) {
            $result['url'] = $imagenExacta->RUTA;
            $result['id'] = $imagenExacta->ID_IMAGEN;
            $result['match_type'] = 'exact';
            return $result;
        }

        // 2. Buscar coincidencia normalizada
        foreach ($imagenesMap as $imagen) {
            $nombreImagenNormalizado = self::cleanString($imagen->NOMBRE_IMAGEN);

            if ($nombreImagenNormalizado === $nombreNormalizado) {
                $result['url'] = $imagen->RUTA;
                $result['id'] = $imagen->ID_IMAGEN;
                $result['match_type'] = 'normalized';
                return $result;
            }
        }

        // 3. Buscar coincidencia por palabras clave (≥4 caracteres)
        $palabrasClave = self::extractKeywords($nombreNormalizado);

        if (!empty($palabrasClave)) {
            foreach ($imagenesMap as $imagen) {
                $nombreImagenNormalizado = self::cleanString($imagen->NOMBRE_IMAGEN);

                foreach ($palabrasClave as $palabra) {
                    if (strlen($palabra) >= 4 && stripos($nombreImagenNormalizado, $palabra) !== false) {
                        $result['url'] = $imagen->RUTA;
                        $result['id'] = $imagen->ID_IMAGEN;
                        $result['match_type'] = 'keyword';
                        return $result;
                    }
                }
            }
        }

        // 4. Buscar coincidencia por nombre contenido
        foreach ($imagenesMap as $imagen) {
            $nombreImagenNormalizado = self::cleanString($imagen->NOMBRE_IMAGEN);

            if (stripos($nombreImagenNormalizado, $nombreNormalizado) !== false && strlen($nombreImagenNormalizado) > strlen($nombreNormalizado)) {
                $result['url'] = $imagen->RUTA;
                $result['id'] = $imagen->ID_IMAGEN;
                $result['match_type'] = 'contains';
                return $result;
            }
        }

        // Retornar null si no encuentra imagen (fallback premium en la vista)
        return $result;
    }
}
