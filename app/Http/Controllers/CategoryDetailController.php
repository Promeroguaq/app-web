<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ImageHelper;

class CategoryDetailController extends Controller
{
    /**
     * Show category detail for a department
     */
    public function showDepartmentCategory($id, $categoria)
    {
        try {
            set_time_limit(120);
            
            // Get department info
            $departamento = DB::table('tabla_departamentos')
                ->where('ID_DEPARTAMENTO', $id)
                ->first();
            
            if (!$departamento) {
                abort(404);
            }
            
            // Build category data
            $categoryData = $this->buildCategoryData('department', $departamento, $categoria);
            
            return view('pages.detalle-categoria', $categoryData);
            
        } catch (\Exception $e) {
            \Log::error("Error loading department category: " . $e->getMessage());
            abort(404);
        }
    }
    
    /**
     * Show category detail for a municipality
     */
    public function showMunicipalityCategory($id, $categoria)
    {
        try {
            set_time_limit(120);
            
            // Get municipality info
            $municipio = DB::table('tabla_municipios')
                ->join('tabla_departamentos', 'tabla_municipios.ID_DEPARTAMENTO', '=', 'tabla_departamentos.ID_DEPARTAMENTO')
                ->select('tabla_municipios.*', 'tabla_departamentos.NOMBRE_DEPARTAMENTO as departamento_nombre')
                ->where('tabla_municipios.ID_MUNICIPIOS', $id)
                ->first();
            
            if (!$municipio) {
                abort(404);
            }
            
            // Build category data
            $categoryData = $this->buildCategoryData('municipality', $municipio, $categoria);
            
            return view('pages.detalle-categoria', $categoryData);
            
        } catch (\Exception $e) {
            \Log::error("Error loading municipality category: " . $e->getMessage());
            abort(404);
        }
    }

    /**
     * Show category detail for a department by slug
     */
    public function showDepartmentCategoryBySlug($departmentSlug, $categorySlug)
    {
        try {
            set_time_limit(120);
            
            // Normalize slug for search
            $normalizedSlug = $this->normalizeText($departmentSlug);
            
            // Get department info by slug
            $departamento = DB::table('tabla_departamentos')
                ->whereRaw('LOWER(NOMBRE_DEPARTAMENTO) LIKE ?', ['%' . str_replace('-', ' ', $normalizedSlug) . '%'])
                ->orWhere('ID_DEPARTAMENTO', $departmentSlug)
                ->first();
            
            if (!$departamento) {
                \Log::error("Department not found for slug: " . $departmentSlug);
                return view('pages.detalle-categoria', [
                    'error' => 'Departamento no encontrado',
                    'entityType' => 'department',
                    'entityName' => 'Desconocido',
                    'category' => $categorySlug,
                ]);
            }
            
            // Build category data
            $categoryData = $this->buildCategoryData('department', $departamento, $categorySlug);
            
            return view('pages.detalle-categoria', $categoryData);
            
        } catch (\Exception $e) {
            \Log::error("Error loading department category by slug: " . $e->getMessage());
            return view('pages.detalle-categoria', [
                'error' => 'Error al cargar la categoría',
                'entityType' => 'department',
                'entityName' => 'Desconocido',
                'category' => $categorySlug,
            ]);
        }
    }
    
    /**
     * Show category detail for a municipality by slug
     */
    public function showMunicipalityCategoryBySlug($departmentSlug, $municipalitySlug, $categorySlug)
    {
        try {
            set_time_limit(120);
            
            // Normalize slugs for search
            $normalizedMunicipalitySlug = $this->normalizeText($municipalitySlug);
            $normalizedDepartmentSlug = $this->normalizeText($departmentSlug);
            
            // Get municipality info by slugs
            $municipio = DB::table('tabla_municipios')
                ->join('tabla_departamentos', 'tabla_municipios.ID_DEPARTAMENTO', '=', 'tabla_departamentos.ID_DEPARTAMENTO')
                ->select('tabla_municipios.*', 'tabla_departamentos.NOMBRE_DEPARTAMENTO as departamento_nombre')
                ->whereRaw('LOWER(tabla_municipios.NOMBRE_MUNICIPIOS) LIKE ?', ['%' . str_replace('-', ' ', $normalizedMunicipalitySlug) . '%'])
                ->whereRaw('LOWER(tabla_departamentos.NOMBRE_DEPARTAMENTO) LIKE ?', ['%' . str_replace('-', ' ', $normalizedDepartmentSlug) . '%'])
                ->first();
            
            if (!$municipio) {
                \Log::error("Municipality not found for slugs: " . $departmentSlug . "/" . $municipalitySlug);
                return view('pages.detalle-categoria', [
                    'error' => 'Municipio no encontrado',
                    'entityType' => 'municipality',
                    'entityName' => 'Desconocido',
                    'category' => $categorySlug,
                ]);
            }
            
            // Build category data
            $categoryData = $this->buildCategoryData('municipality', $municipio, $categorySlug);
            
            return view('pages.detalle-categoria', $categoryData);
            
        } catch (\Exception $e) {
            \Log::error("Error loading municipality category by slug: " . $e->getMessage());
            return view('pages.detalle-categoria', [
                'error' => 'Error al cargar la categoría',
                'entityType' => 'municipality',
                'entityName' => 'Desconocido',
                'category' => $categorySlug,
            ]);
        }
    }

    /**
     * Normalize text for slug comparison
     */
    private function normalizeText($text)
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
    
    /**
     * Build category data based on entity type and category
     */
    private function buildCategoryData($entityType, $entity, $categoria)
    {
        // Entity name
        $entityName = $entityType === 'department' 
            ? $entity->NOMBRE_DEPARTAMENTO 
            : $entity->NOMBRE_MUNICIPIOS;
        
        // Category configurations
        $categoryConfig = $this->getCategoryConfig($categoria, $entityName);
        
        // Build title
        $title = ucfirst(str_replace('_', ' ', $categoria)) . ' de ' . $entityName;
        
        // Get hero image with fallback
        $heroImage = $this->getCategoryFallbackImage($categoria);
        
        // Get featured places based on entity type
        $featuredPlaces = $this->getFeaturedPlaces($entityType, $entity, $categoria);
        
        // Get gallery images
        $gallery = $this->getGalleryImages($categoria);
        
        // Get experiences based on category
        $experiences = $this->getExperiences($categoria);
        
        // Get events - only if category is eventos or general
        $events = ($categoria === 'eventos') ? $this->getEvents($entityType, $entity, $categoria) : [];
        
        // Get gastronomy - only if category is gastronomia or general
        $gastronomy = ($categoria === 'gastronomia') ? $this->getGastronomy($entityType, $entity, $categoria) : [];
        
        // Get related destinations
        $relatedDestinations = $this->getRelatedDestinations($entityType, $entity);
        
        return [
            'entityType' => $entityType,
            'entityName' => $entityName,
            'entity' => $entity,
            'category' => $categoria,
            'categoryConfig' => $categoryConfig,
            'title' => $title,
            'subtitle' => $categoryConfig['subtitle'] ?? '',
            'heroImage' => $heroImage,
            'badges' => $categoryConfig['badges'] ?? [],
            'description' => $categoryConfig['description'] ?? '',
            'mainTopics' => $categoryConfig['mainTopics'] ?? [],
            'featuredItemsTitle' => $categoryConfig['featuredItemsTitle'] ?? 'Lugares destacados',
            'experiencesTitle' => $categoryConfig['experiencesTitle'] ?? 'Experiencias',
            'gallery' => $gallery,
            'featuredPlaces' => $featuredPlaces,
            'experiences' => $experiences,
            'events' => $events,
            'gastronomy' => $gastronomy,
            'relatedDestinations' => $relatedDestinations,
        ];
    }
    
    /**
     * Get category fallback image
     */
    private function getCategoryFallbackImage($categoria)
    {
        $fallbackImages = [
            'paisajes' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
            'cultura' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
            'gastronomia' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
            'naturaleza' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
            'eventos' => 'https://images.unsplash.com/photo-1464207687429-7505649dae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
        ];
        
        return $fallbackImages[$categoria] ?? $fallbackImages['paisajes'];
    }
    
    /**
     * Get category configuration
     */
    private function getCategoryConfig($categoria, $entityName)
    {
        $configs = [
            'paisajes' => [
                'subtitle' => 'Montañas, cafetales y pueblos suspendidos entre la niebla.',
                'description' => $entityName . ' se descubre entre montañas verdes, caminos cafeteros y miradores donde la niebla parece tocar los pueblos. Cada paisaje cuenta una parte de la identidad de la región.',
                'badges' => ['Montañas', 'Cafetales', 'Miradores', 'Fotografía'],
                'mainTopics' => ['Miradores naturales', 'Pueblos de montaña', 'Rutas panorámicas', 'Atardeceres'],
                'featuredItemsTitle' => 'Paisajes que debes descubrir',
                'experiencesTitle' => 'Experiencias escénicas',
            ],
            'cultura' => [
                'subtitle' => 'Pueblos coloridos, tradición y memoria viva.',
                'description' => 'La cultura de ' . $entityName . ' se vive en sus pueblos, plazas, balcones, ferias, arquitectura y en la calidez de su gente. Cada tradición cuenta la historia de quienes habitan estas tierras.',
                'badges' => ['Tradición', 'Pueblos', 'Artesanías', 'Historia'],
                'mainTopics' => ['Pueblos patrimoniales', 'Arquitectura tradicional', 'Museos', 'Artesanías'],
                'featuredItemsTitle' => 'Lugares culturales destacados',
                'experiencesTitle' => 'Experiencias culturales',
            ],
            'gastronomia' => [
                'subtitle' => 'Sabores auténticos, café de origen y tradición servida en la mesa.',
                'description' => 'La cocina de ' . $entityName . ' mezcla tradición campesina, abundancia y sabores familiares que hacen parte de la identidad local. Cada plato es una experiencia que conecta con las raíces.',
                'badges' => ['Platos típicos', 'Café', 'Arepas', 'Mercados'],
                'mainTopics' => ['Platos típicos', 'Café de origen', 'Mercados locales', 'Dulces tradicionales'],
                'featuredItemsTitle' => 'Sabores que debes probar',
                'experiencesTitle' => 'Experiencias gastronómicas',
            ],
            'naturaleza' => [
                'subtitle' => 'Ríos, cascadas, reservas y caminos verdes.',
                'description' => 'La naturaleza de ' . $entityName . ' combina montañas, bosques, aguas cristalinas y reservas ideales para el ecoturismo. Cada sendero revela la biodiversidad de la región.',
                'badges' => ['Reservas', 'Cascadas', 'Senderismo', 'Aves'],
                'mainTopics' => ['Parques naturales', 'Reservas ecológicas', 'Cascadas', 'Senderos'],
                'featuredItemsTitle' => 'Naturaleza que debes explorar',
                'experiencesTitle' => 'Experiencias naturales',
            ],
            'eventos' => [
                'subtitle' => 'Ferias, flores, música y celebraciones que llenan de vida la región.',
                'description' => 'Los eventos de ' . $entityName . ' celebran la identidad local a través de flores, música, tradición, gastronomía y encuentros populares. Cada celebración es una fiesta de la cultura.',
                'badges' => ['Ferias', 'Flores', 'Música', 'Tradición'],
                'mainTopics' => ['Ferias principales', 'Fiestas patronales', 'Festivales culturales', 'Eventos musicales'],
                'featuredItemsTitle' => 'Eventos que debes vivir',
                'experiencesTitle' => 'Experiencias festivas',
            ],
        ];
        
        return $configs[$categoria] ?? [
            'subtitle' => 'Descubre lo mejor de ' . $entityName . '.',
            'description' => 'Una experiencia única que te conecta con la esencia de ' . $entityName . '.',
            'badges' => ['Turismo premium', 'Experiencias únicas'],
            'mainTopics' => ['Destacados', 'Experiencias', 'Lugares'],
            'featuredItemsTitle' => 'Lugares destacados',
            'experiencesTitle' => 'Experiencias',
        ];
    }
    
    /**
     * Get featured places based on category
     */
    private function getFeaturedPlaces($entityType, $entity, $categoria)
    {
        $places = [];
        $entityName = $entityType === 'department'
            ? $entity->NOMBRE_DEPARTAMENTO
            : $entity->NOMBRE_MUNICIPIOS;

        // Category-specific featured items
        $categoryItems = $this->getCategorySpecificItems($categoria, $entityName, $entity, $entityType);

        if ($entityType === 'department') {
            // Get department slug
            $departmentSlug = $this->normalizeText($entity->NOMBRE_DEPARTAMENTO);

            // Get municipalities in this department
            $municipios = DB::table('tabla_municipios')
                ->where('ID_DEPARTAMENTO', $entity->ID_DEPARTAMENTO)
                ->orderBy('NOMBRE_MUNICIPIOS')
                ->limit(6)
                ->get();

            foreach ($municipios as $index => $municipio) {
                $itemData = $categoryItems[$index] ?? $categoryItems[0];
                $municipalitySlug = $this->normalizeText($municipio->NOMBRE_MUNICIPIOS);
                $places[] = [
                    'name' => $municipio->NOMBRE_MUNICIPIOS,
                    'description' => $itemData['description'],
                    'location' => $itemData['location'] ?? $entity->NOMBRE_DEPARTAMENTO,
                    'rating' => 4.8,
                    'image' => 'https://images.unsplash.com/photo-1512458872269-b63f40c78571?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'url' => route('municipios.show.slugs', [$departmentSlug, $municipalitySlug]),
                ];
            }
        } else {
            // For municipalities, show category-specific places
            foreach ($categoryItems as $itemData) {
                $places[] = [
                    'name' => $itemData['name'],
                    'description' => $itemData['description'],
                    'location' => $itemData['location'] ?? $entityName,
                    'rating' => 4.7,
                    'image' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'url' => '#',
                ];
            }
        }

        return $places;
    }

    /**
     * Load category items from database tables
     */
    private function loadCategoryItemsFromDB($categoria, $entity = null, $entityType = null)
    {
        $items = [];
        $categoryTableMap = [
            'cultura' => ['tabla_museos', 'tabla_iglesias'],
            'naturaleza' => ['tabla_reservas', 'tabla_termales', 'tabla_playas'],
            'gastronomia' => ['tabla_gastronomia'],
            'aventura' => ['tabla_deporte_aventura', 'tabla_ciclismo'],
            'eventos' => ['tabla_ferias'],
        ];

        $tables = $categoryTableMap[$categoria] ?? [];

        foreach ($tables as $table) {
            try {
                $query = DB::table($table);

                // Filter by entity if provided
                if ($entity && $entityType === 'municipality') {
                    // Try to filter by municipality if the table has that column
                    if (Schema::hasColumn($table, 'ID_MUNICIPIOS')) {
                        $query->where('ID_MUNICIPIOS', $entity->ID_MUNICIPIOS);
                    }
                    // For gastronomia table, filter by department name
                    elseif ($table === 'tabla_gastronomia' && isset($entity->NOMBRE_DEPARTAMENTO)) {
                        $query->where('DEPARTAMENTO', 'like', '%' . $entity->NOMBRE_DEPARTAMENTO . '%');
                    }
                } elseif ($entity && $entityType === 'department') {
                    // Try to filter by department if the table has that column
                    if (Schema::hasColumn($table, 'ID_DEPARTAMENTO')) {
                        $query->where('ID_DEPARTAMENTO', $entity->ID_DEPARTAMENTO);
                    }
                    // For gastronomia table, filter by department name
                    elseif ($table === 'tabla_gastronomia' && isset($entity->NOMBRE_DEPARTAMENTO)) {
                        $query->where('DEPARTAMENTO', 'like', '%' . $entity->NOMBRE_DEPARTAMENTO . '%');
                    }
                }

                $dbItems = $query->limit(6)->get();

                foreach ($dbItems as $item) {
                    $normalizedItem = $this->normalizeDatabaseItem($item, $table, $categoria);
                    if ($normalizedItem) {
                        $items[] = $normalizedItem;
                    }
                }
            } catch (\Exception $e) {
                \Log::warning("Could not load items from table $table: " . $e->getMessage());
            }
        }

        return $items;
    }

    /**
     * Normalize database item to standard format
     */
    private function normalizeDatabaseItem($item, $table, $categoria)
    {
        $name = null;
        $description = null;

        // Try different field names for name (uppercase for tabla_ tables)
        $nameFields = [
            'NOMBRE_MUSEO',
            'NOMBRE_IGLESIA',
            'NOMBRE_RESERVAS_O_PARQUES',
            'NOMBRE_TERMAL',
            'NOMBRE_PLAYA',
            'PLATOS_TIPICOS',
            'NOMBRE_DEPORTES_AVENTURA',
            'NOMBRE_RUTA_CICLISMO',
            'NOMBRE_FERIAS_Y_FIESTAS',
            'NOMBRE',
            'nombre',
            'nombre_museo',
            'nombre_iglesia',
            'nombre_plato',
            'name'
        ];
        foreach ($nameFields as $field) {
            if (isset($item->$field) && !empty($item->$field)) {
                $name = $item->$field;
                break;
            }
        }

        // Try different field names for description (uppercase for tabla_ tables)
        $descFields = ['DESCRIPCION', 'descripcion', 'description', 'resumen', 'contenido'];
        foreach ($descFields as $field) {
            if (isset($item->$field) && !empty($item->$field)) {
                $description = $item->$field;
                break;
            }
        }

        if (!$name) {
            return null;
        }

        // Log warning if no real description
        if (!$description) {
            \Log::warning("Item without real description: " . $name . " from table " . $table);
        }

        return [
            'name' => $name,
            'description' => $description ?? $this->getFallbackDescription($categoria, $name),
            'location' => 'Ubicación disponible',
            'rating' => 4.5,
            'image' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'url' => '#',
            'table' => $table,
            'id' => $item->id ?? $item->id_museo ?? $item->id_iglesia ?? $item->{'COL 1'} ?? null,
        ];
    }

    /**
     * Get fallback description by category
     */
    private function getFallbackDescription($categoria, $itemName)
    {
        $fallbacks = [
            'cultura' => "Un espacio que refleja la identidad cultural, la memoria local y las tradiciones del destino.",
            'naturaleza' => "Un entorno natural ideal para descubrir paisajes, biodiversidad y tranquilidad.",
            'gastronomia' => "Una experiencia de sabores locales que conecta la cocina tradicional con la identidad del territorio.",
            'aventura' => "Una actividad emocionante para explorar el destino desde una perspectiva única.",
            'eventos' => "Una celebración que reúne tradición, comunidad y expresiones culturales del destino.",
            'paisajes' => "Un lugar para contemplar el territorio, sus colores, su luz y sus escenarios naturales.",
        ];

        return $fallbacks[$categoria] ?? "Descubre más sobre este lugar del destino.";
    }
    
    /**
     * Get category-specific items with contextual data based on destination
     */
    private function getCategorySpecificItems($categoria, $entityName, $entity = null, $entityType = null)
    {
        // Try to load real data from database first
        $dbItems = $this->loadCategoryItemsFromDB($categoria, $entity, $entityType);

        if (!empty($dbItems)) {
            return $dbItems;
        }

        // Normalize entity name for matching
        $normalizedEntity = strtolower($entityName);

        // Contextual items based on specific destinations
        $contextualItems = $this->getContextualItems($categoria, $normalizedEntity, $entityName);

        if (!empty($contextualItems)) {
            return $contextualItems;
        }

        // Fallback to generic items with entity name
        $items = [
            'paisajes' => [
                ['name' => 'Mirador Principal', 'description' => 'Vista panorámica de las montañas y valles de ' . $entityName, 'location' => 'Centro'],
                ['name' => 'Ruta Panorámica', 'description' => 'Camino escénico con vistas impresionantes', 'location' => 'Zona rural'],
                ['name' => 'Cerro Mirador', 'description' => 'Atardeceres inolvidables entre las montañas', 'location' => 'Alta montaña'],
                ['name' => 'Valle Verde', 'description' => 'Paisajes verdes que se pierden en el horizonte', 'location' => 'Valle'],
                ['name' => 'Pueblo en la Nube', 'description' => 'Pueblo suspendido entre la niebla', 'location' => 'Alta montaña'],
                ['name' => 'Río de Montaña', 'description' => 'Aguas cristalinas rodeadas de naturaleza', 'location' => 'Cañón'],
            ],
            'cultura' => [
                ['name' => 'Plaza Principal', 'description' => 'Corazón histórico con arquitectura colonial', 'location' => 'Centro'],
                ['name' => 'Museo Local', 'description' => 'Historia y tradiciones de ' . $entityName, 'location' => 'Centro'],
                ['name' => 'Iglesia Colonial', 'description' => 'Patrimonio religioso y arquitectónico', 'location' => 'Centro'],
                ['name' => 'Casa de Cultura', 'description' => 'Artesanías y expresiones artísticas locales', 'location' => 'Centro'],
                ['name' => 'Barrio Antiguo', 'description' => 'Calles empedradas y balcones coloridos', 'location' => 'Centro histórico'],
                ['name' => 'Mercado Artesanal', 'description' => 'Artesanías tradicionales y productos locales', 'location' => 'Centro'],
            ],
            'gastronomia' => [
                ['name' => 'Restaurante Típico', 'description' => 'Platos tradicionales de la región', 'location' => 'Centro'],
                ['name' => 'Café de Origen', 'description' => 'Experiencia cafetera auténtica', 'location' => 'Zona cafetera'],
                ['name' => 'Mercado Local', 'description' => 'Productos frescos y sabores locales', 'location' => 'Centro'],
                ['name' => 'Panadería Tradicional', 'description' => 'Pan y dulces hechos a mano', 'location' => 'Centro'],
                ['name' => 'Fonda Paisa', 'description' => 'Comida casera y ambiente familiar', 'location' => 'Centro'],
                ['name' => 'Dulcería', 'description' => 'Dulces tradicionales de la región', 'location' => 'Centro'],
            ],
            'naturaleza' => [
                ['name' => 'Parque Natural', 'description' => 'Reserva ecológica con biodiversidad', 'location' => 'Zona rural'],
                ['name' => 'Cascada Principal', 'description' => 'Aguas cristalinas en medio del bosque', 'location' => 'Montaña'],
                ['name' => 'Sendero Ecológico', 'description' => 'Ruta de senderismo por la naturaleza', 'location' => 'Bosque'],
                ['name' => 'Río Cristalino', 'description' => 'Baños naturales y paisajes verdes', 'location' => 'Cañón'],
                ['name' => 'Mirador de Aves', 'description' => 'Avistamiento de aves tropicales', 'location' => 'Reserva'],
                ['name' => 'Bosque Nublado', 'description' => 'Vegetación exuberante y niebla', 'location' => 'Alta montaña'],
            ],
            'eventos' => [
                ['name' => 'Feria Principal', 'description' => 'Celebración tradicional de ' . $entityName, 'location' => 'Centro'],
                ['name' => 'Festival Cultural', 'description' => 'Música, danza y expresiones artísticas', 'location' => 'Centro'],
                ['name' => 'Fiesta Patronal', 'description' => 'Celebración religiosa y popular', 'location' => 'Centro'],
                ['name' => 'Evento Musical', 'description' => 'Conciertos y presentaciones en vivo', 'location' => 'Centro'],
                ['name' => 'Feria Gastronómica', 'description' => 'Sabores locales y cocina tradicional', 'location' => 'Centro'],
                ['name' => 'Carnaval Local', 'description' => 'Color, música y alegría popular', 'location' => 'Centro'],
            ],
        ];

        return $items[$categoria] ?? $items['paisajes'];
    }

    /**
     * Get contextual items based on specific destination
     */
    private function getContextualItems($categoria, $normalizedEntity, $entityName)
    {
        $contextualData = [];

        // Barranquilla - Gastronomía
        if (strpos($normalizedEntity, 'barranquilla') !== false && $categoria === 'gastronomia') {
            $contextualData = [
                ['name' => 'Butifarra Soledeña', 'description' => 'Embutido tradicional del Atlántico, símbolo de la cocina caribeña.', 'location' => 'Soledad'],
                ['name' => 'Arroz de Lisa', 'description' => 'Plato de pescado con arroz, cocinado en hoja de plátano.', 'location' => 'Barranquilla'],
                ['name' => 'Arepas de Huevo', 'description' => 'Arepas fritas con huevo, clásico del desayuno caribeño.', 'location' => 'Centro'],
                ['name' => 'Dulces de Leche', 'description' => 'Postres tradicionales hechos con leche de coco y panela.', 'location' => 'Mercado'],
                ['name' => 'Pescado Frito', 'description' => 'Pescado fresco del Caribe acompañado de patacones.', 'location' => 'Puerto'],
                ['name' => 'Bollos de Yuca', 'description' => 'Bollos de yuca envueltos en hoja de bijao.', 'location' => 'Centro'],
            ];
        }
        // Medellín - Gastronomía
        elseif (strpos($normalizedEntity, 'medellin') !== false && $categoria === 'gastronomia') {
            $contextualData = [
                ['name' => 'Bandeja Paisa', 'description' => 'El plato más representativo de Antioquia con frijoles, carne, chicharrón y más.', 'location' => 'Centro'],
                ['name' => 'Arepas Antioqueñas', 'description' => 'Arepas de maíz con queso, acompañamiento esencial.', 'location' => 'Centro'],
                ['name' => 'Café de Origen', 'description' => 'Café de alta calidad de los cafetales de Antioquia.', 'location' => 'Envigado'],
                ['name' => 'Sancocho Antioqueño', 'description' => 'Sopa tradicional con carne, papa, yuca y plátano.', 'location' => 'Centro'],
                ['name' => 'Dulces de Envigado', 'description' => 'Dulces tradicionales de la región antioqueña.', 'location' => 'Envigado'],
                ['name' => 'Mondongo', 'description' => 'Sopa de mondongo con salsa de tomate y limón.', 'location' => 'Centro'],
            ];
        }
        // Cartagena - Cultura
        elseif (strpos($normalizedEntity, 'cartagena') !== false && $categoria === 'cultura') {
            $contextualData = [
                ['name' => 'Ciudad Amurallada', 'description' => 'Centro histórico colonial declarado Patrimonio de la Humanidad.', 'location' => 'Centro'],
                ['name' => 'Castillo de San Felipe', 'description' => 'Fortaleza colonial que defendió la ciudad de piratas.', 'location' => 'San Lázaro'],
                ['name' => 'Palacio de la Inquisición', 'description' => 'Museo de historia colonial y la Inquisición española.', 'location' => 'Centro'],
                ['name' => 'Plaza de los Coches', 'description' => 'Plaza histórica con arquitectura colonial y comercio tradicional.', 'location' => 'Centro'],
                ['name' => 'Iglesia de San Pedro Claver', 'description' => 'Templo colonial dedicado al santo patrono de los esclavos.', 'location' => 'Centro'],
                ['name' => 'Las Bóvedas', 'description' => 'Arcos coloniales que servían como bodegas y prisión.', 'location' => 'Murallas'],
            ];
        }
        // Amazonas - Naturaleza
        elseif (strpos($normalizedEntity, 'amazonas') !== false && $categoria === 'naturaleza') {
            $contextualData = [
                ['name' => 'Reserva Nacional Natural Amacayacu', 'description' => 'Reserva de selva húmeda con biodiversidad amazónica.', 'location' => 'Leticia'],
                ['name' => 'Río Amazonas', 'description' => 'El río más caudaloso del mundo, corazón de la selva.', 'location' => 'Leticia'],
                ['name' => 'Isla de los Micos', 'description' => 'Isla con población de monos en libertad.', 'location' => 'Río Amazonas'],
                ['name' => 'Lago Tarapoto', 'description' => 'Lago de aguas negras con delfines de río.', 'location' => 'Puerto Nariño'],
                ['name' => 'Santuario de Fauna Flora Cahuinarí', 'description' => 'Área protegida con ecosistemas de selva y ríos.', 'location' => 'Amazonas'],
                ['name' => 'Yarinacocha', 'description' => 'Lago oxbow con vegetación acuática y aves.', 'location' => 'Perú'],
            ];
        }
        // Antioquia - Eventos
        elseif (strpos($normalizedEntity, 'antioquia') !== false && $categoria === 'eventos') {
            $contextualData = [
                ['name' => 'Feria de las Flores', 'description' => 'Festival emblemático de Medellín con desfiles de silleteros.', 'location' => 'Medellín'],
                ['name' => 'Festival de Música de Medellín', 'description' => 'Evento musical con artistas nacionales e internacionales.', 'location' => 'Medellín'],
                ['name' => 'Fiesta de la Candelaria', 'description' => 'Celebración religiosa y cultural en Rionegro.', 'location' => 'Rionegro'],
                ['name' => 'Festival de Tango', 'description' => 'Festival de tango y música de cámara en Medellín.', 'location' => 'Medellín'],
                ['name' => 'Feria del Libro', 'description' => 'Evento literario con autores y editoriales.', 'location' => 'Medellín'],
                ['name' => 'Alumbrados Navideños', 'description' => 'Luces navideñas que decoran la ciudad en diciembre.', 'location' => 'Medellín'],
            ];
        }
        // Barranquilla - Eventos
        elseif (strpos($normalizedEntity, 'barranquilla') !== false && $categoria === 'eventos') {
            $contextualData = [
                ['name' => 'Carnaval de Barranquilla', 'description' => 'El carnaval más grande de Colombia, declarado Patrimonio Oral.', 'location' => 'Barranquilla'],
                ['name' => 'Festival de Orquestas', 'description' => 'Competencia de orquestas de música caribeña.', 'location' => 'Barranquilla'],
                ['name' => 'Joselito Carnaval', 'description' => 'Tradición de quema de muñecos simbólicos.', 'location' => 'Barranquilla'],
                ['name' => 'Batalla de Flores', 'description' => 'Desfile de carrozas y comparsas en el carnaval.', 'location' => 'Vía 40'],
                ['name' => 'Gran Parada', 'description' => 'Desfile de marimondas, monocucos y disfraces.', 'location' => 'Vía 40'],
                ['name' => 'Festival de Música del Caribe', 'description' => 'Evento de música tradicional caribeña.', 'location' => 'Barranquilla'],
            ];
        }

        return $contextualData;
    }
    
    /**
     * Get gallery images
     */
    private function getGalleryImages($categoria)
    {
        $gallery = [];
        
        $images = [
            'paisajes' => [
                ['title' => 'Montañas', 'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306'],
                ['title' => 'Valles', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4'],
                ['title' => 'Atardeceres', 'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470'],
                ['title' => 'Horizontes', 'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e'],
            ],
            'cultura' => [
                ['title' => 'Arquitectura', 'image' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd'],
                ['title' => 'Museos', 'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b'],
                ['title' => 'Artesanías', 'image' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de'],
                ['title' => 'Tradiciones', 'image' => 'https://images.unsplash.com/photo-1464207687429-7505649dae38'],
            ],
            'gastronomia' => [
                ['title' => 'Platos típicos', 'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836'],
                ['title' => 'Mercados', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4'],
                ['title' => 'Café', 'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085'],
                ['title' => 'Restaurantes', 'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0'],
            ],
            'naturaleza' => [
                ['title' => 'Cascadas', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4'],
                ['title' => 'Bosques', 'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e'],
                ['title' => 'Ríos', 'image' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de'],
                ['title' => 'Reservas', 'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e'],
            ],
            'eventos' => [
                ['title' => 'Festivales', 'image' => 'https://images.unsplash.com/photo-1464207687429-7505649dae38'],
                ['title' => 'Ferias', 'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30'],
                ['title' => 'Celebraciones', 'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3'],
                ['title' => 'Tradiciones', 'image' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4'],
            ],
        ];
        
        $categoryImages = $images[$categoria] ?? $images['paisajes'];
        
        foreach ($categoryImages as $img) {
            $gallery[] = [
                'title' => $img['title'],
                'image' => $img['image'] . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'description' => 'Descubre la belleza de ' . $img['title'],
            ];
        }
        
        return $gallery;
    }
    
    /**
     * Get experiences based on category
     */
    private function getExperiences($categoria)
    {
        $experiences = [
            'paisajes' => [
                [
                    'title' => 'Miradores naturales',
                    'description' => 'Contempla montañas, valles y panorámicas únicas del destino.',
                    'type' => 'miradores',
                    'badge' => '01'
                ],
                [
                    'title' => 'Caminatas panorámicas',
                    'description' => 'Recorre senderos suaves entre paisajes abiertos y caminos rurales.',
                    'type' => 'caminatas',
                    'badge' => '02'
                ],
                [
                    'title' => 'Fotografía de paisaje',
                    'description' => 'Captura atardeceres, montañas y rincones memorables.',
                    'type' => 'fotografia',
                    'badge' => '03'
                ],
                [
                    'title' => 'Atardeceres',
                    'description' => 'Vive momentos dorados donde la luz transforma el paisaje.',
                    'type' => 'atardeceres',
                    'badge' => '04'
                ],
            ],
            'cultura' => [
                [
                    'title' => 'Pueblos patrimoniales',
                    'description' => 'Calles, plazas y balcones que conservan la identidad local.',
                    'type' => 'pueblos',
                    'badge' => '01'
                ],
                [
                    'title' => 'Artesanías',
                    'description' => 'Oficios tradicionales hechos a mano por comunidades locales.',
                    'type' => 'artesanias',
                    'badge' => '02'
                ],
                [
                    'title' => 'Arquitectura local',
                    'description' => 'Fachadas, templos y espacios que narran la historia del destino.',
                    'type' => 'arquitectura',
                    'badge' => '03'
                ],
                [
                    'title' => 'Museos e historia',
                    'description' => 'Recorridos para entender la memoria cultural del lugar.',
                    'type' => 'museos',
                    'badge' => '04'
                ],
            ],
            'gastronomia' => [
                [
                    'title' => 'Cocina tradicional',
                    'description' => 'Platos típicos que cuentan la historia local desde la mesa.',
                    'type' => 'cocina',
                    'badge' => '01'
                ],
                [
                    'title' => 'Mercados locales',
                    'description' => 'Sabores frescos, productos regionales y vida cotidiana.',
                    'type' => 'mercados',
                    'badge' => '02'
                ],
                [
                    'title' => 'Café de origen',
                    'description' => 'Experiencias alrededor del aroma, el cultivo y la tradición cafetera.',
                    'type' => 'cafe',
                    'badge' => '03'
                ],
                [
                    'title' => 'Dulces y amasijos',
                    'description' => 'Recetas populares que hacen parte de la memoria familiar.',
                    'type' => 'dulces',
                    'badge' => '04'
                ],
            ],
            'naturaleza' => [
                [
                    'title' => 'Senderismo',
                    'description' => 'Caminos naturales para explorar el territorio a otro ritmo.',
                    'type' => 'senderismo',
                    'badge' => '01'
                ],
                [
                    'title' => 'Cascadas y ríos',
                    'description' => 'Agua, frescura y paisajes vivos en entornos naturales.',
                    'type' => 'cascadas',
                    'badge' => '02'
                ],
                [
                    'title' => 'Reservas naturales',
                    'description' => 'Espacios protegidos para conectar con la biodiversidad.',
                    'type' => 'reservas',
                    'badge' => '03'
                ],
                [
                    'title' => 'Avistamiento de aves',
                    'description' => 'Una experiencia tranquila para descubrir la riqueza natural.',
                    'type' => 'aves',
                    'badge' => '04'
                ],
            ],
            'eventos' => [
                [
                    'title' => 'Ferias tradicionales',
                    'description' => 'Celebraciones locales llenas de música, gastronomía y memoria popular.',
                    'type' => 'ferias',
                    'badge' => '01'
                ],
                [
                    'title' => 'Carnavales y color',
                    'description' => 'Desfiles, comparsas y expresiones culturales llenas de energía.',
                    'type' => 'carnavales',
                    'badge' => '02'
                ],
                [
                    'title' => 'Fiestas patronales',
                    'description' => 'Encuentros comunitarios donde la tradición cobra vida.',
                    'type' => 'fiestas',
                    'badge' => '03'
                ],
                [
                    'title' => 'Festivales culturales',
                    'description' => 'Música, arte y escenarios vivos que conectan con la identidad local.',
                    'type' => 'festivales',
                    'badge' => '04'
                ],
            ],
        ];

        // Add images to experiences
        $categoryExperiences = $experiences[$categoria] ?? $experiences['paisajes'];
        foreach ($categoryExperiences as &$experience) {
            $experience['image'] = ImageHelper::getExperienceImage($categoria, $experience['type']);
        }

        return $categoryExperiences;
    }
    
    /**
     * Get events
     */
    private function getEvents($entityType, $entity, $categoria)
    {
        $entityName = $entityType === 'department' 
            ? $entity->NOMBRE_DEPARTAMENTO 
            : $entity->NOMBRE_MUNICIPIOS;
        
        $events = [
            'eventos' => [
                [
                    'name' => 'Festival Principal de ' . $entityName,
                    'date' => 'Marzo 15-20',
                    'description' => 'Celebración de las tradiciones locales con música, danza y gastronomía.',
                    'location' => $entityName,
                ],
                [
                    'name' => 'Feria de ' . $entityName,
                    'date' => 'Abril 10-15',
                    'description' => 'Muestra de los mejores sabores y productos de la región.',
                    'location' => $entityName,
                ],
                [
                    'name' => 'Carnaval Local',
                    'date' => 'Enero 20-25',
                    'description' => 'Color, música y alegría popular en las calles de ' . $entityName,
                    'location' => $entityName,
                ],
                [
                    'name' => 'Fiesta Patronal',
                    'date' => 'Julio 5-10',
                    'description' => 'Celebración religiosa y tradicional del municipio.',
                    'location' => $entityName,
                ],
            ],
        ];
        
        return $events[$categoria] ?? [];
    }
    
    /**
     * Get gastronomy
     */
    private function getGastronomy($entityType, $entity, $categoria)
    {
        $entityName = $entityType === 'department' 
            ? $entity->NOMBRE_DEPARTAMENTO 
            : $entity->NOMBRE_MUNICIPIOS;
        
        $gastronomy = [
            'gastronomia' => [
                [
                    'name' => 'Plato Típico de ' . $entityName,
                    'description' => 'El plato más representativo de la región.',
                    'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                ],
                [
                    'name' => 'Arepas Tradicionales',
                    'description' => 'Tradición en cada bocado.',
                    'image' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                ],
                [
                    'name' => 'Café de Origen',
                    'description' => 'El mejor café del mundo.',
                    'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                ],
                [
                    'name' => 'Dulces Tradicionales',
                    'description' => 'Postres y dulces hechos a mano.',
                    'image' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                ],
                [
                    'name' => 'Mercado Local',
                    'description' => 'Productos frescos y sabores auténticos.',
                    'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                ],
                [
                    'name' => 'Bebidas Típicas',
                    'description' => 'Refrescos y bebidas tradicionales.',
                    'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                ],
            ],
        ];
        
        return $gastronomy[$categoria] ?? [];
    }
    
    /**
     * Get related destinations
     */
    private function getRelatedDestinations($entityType, $entity)
    {
        $related = [];

        if ($entityType === 'department') {
            // Get other departments
            $departments = DB::table('tabla_departamentos')
                ->where('ID_DEPARTAMENTO', '!=', $entity->ID_DEPARTAMENTO)
                ->limit(4)
                ->get();

            foreach ($departments as $dept) {
                $slug = $this->normalizeText($dept->NOMBRE_DEPARTAMENTO);
                $related[] = [
                    'name' => $dept->NOMBRE_DEPARTAMENTO,
                    'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'url' => route('departamentos.show.slug', $slug),
                ];
            }
        } else {
            // Get department name for slug
            $departamento = DB::table('tabla_departamentos')
                ->where('ID_DEPARTAMENTO', $entity->ID_DEPARTAMENTO)
                ->first();

            $departmentSlug = $departamento ? $this->normalizeText($departamento->NOMBRE_DEPARTAMENTO) : '';

            // Get other municipalities in the same department
            $municipios = DB::table('tabla_municipios')
                ->where('ID_DEPARTAMENTO', $entity->ID_DEPARTAMENTO)
                ->where('ID_MUNICIPIOS', '!=', $entity->ID_MUNICIPIOS)
                ->limit(4)
                ->get();

            foreach ($municipios as $municipio) {
                $municipalitySlug = $this->normalizeText($municipio->NOMBRE_MUNICIPIOS);
                $related[] = [
                    'name' => $municipio->NOMBRE_MUNICIPIOS,
                    'image' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                    'url' => route('municipios.show.slugs', [$departmentSlug, $municipalitySlug]),
                ];
            }
        }

        return $related;
    }
}
