<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration for Category Pages
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for all 24 categories including
    | hero images, taglines, accent colors, and category groupings.
    |
    */

    'categories' => [
        // Naturaleza
        'islas' => [
            'name' => 'Islas',
            'emoji' => '🏝️',
            'hero_image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Paraísos rodeados de mar donde Colombia toca el Caribe y el Pacífico',
            'accent_color' => '#0ea5e9', // sky blue
            'type' => 'Naturaleza',
            'description' => 'Islas paradisíacas que ofrecen playas vírgenes, arrecifes de coral y ecosistemas marinos únicos.',
            'related_categories' => ['playas', 'termales', 'reservas-naturales']
        ],
        'termales' => [
            'name' => 'Termales',
            'emoji' => '♨️',
            'hero_image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Aguas que sanan y paisajes que enamoran — la terapia natural de Colombia',
            'accent_color' => '#dc2626', // red
            'type' => 'Naturaleza',
            'description' => 'Fuentes termales naturales con propiedades curativas en entornos montañosos y selváticos.',
            'related_categories' => ['playas', 'islas', 'reservas-naturales']
        ],
        'playas' => [
            'name' => 'Playas',
            'emoji' => '🏖️',
            'hero_image' => 'https://images.unsplash.com/photo-1505228395891-9a51e7e86bf6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Arena blanca, aguas cristalinas y el ritmo inigualable del mar colombiano',
            'accent_color' => '#0891b2', // cyan
            'type' => 'Naturaleza',
            'description' => 'Costas espectaculares con arenas blancas, aguas turquesas y paisajes marinos impresionantes.',
            'related_categories' => ['islas', 'termales', 'reservas-naturales']
        ],
        'reservas-naturales' => [
            'name' => 'Reservas de parques',
            'emoji' => '🌿',
            'hero_image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'La Colombia salvaje y protegida, biodiversidad sin fronteras',
            'accent_color' => '#16a34a', // green
            'type' => 'Naturaleza',
            'description' => 'Áreas protegidas que conservan la increíble biodiversidad de flora y fauna colombiana.',
            'related_categories' => ['playas', 'termales', 'islas']
        ],
        'desiertos-lagunas' => [
            'name' => 'Desiertos y lagunas',
            'emoji' => '🏜️',
            'hero_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Contrastes extremos donde el desierto abraza cuerpos de agua únicos',
            'accent_color' => '#ea580c', // orange
            'type' => 'Naturaleza',
            'description' => 'Paisajes desérticos con oasis y lagunas que crean ecosistemas únicos y sorprendentes.',
            'related_categories' => ['reservas-naturales', 'playas', 'termales']
        ],

        // Deportes y Aventura
        'deportes-aventura' => [
            'name' => 'Deportes de aventura',
            'emoji' => '⛰️',
            'hero_image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Adrenalina pura en los paisajes más espectaculares de Colombia',
            'accent_color' => '#f97316', // orange
            'type' => 'Turismo',
            'description' => 'Actividades extremas y deportes de aventura en montañas, ríos y paisajes naturales.',
            'related_categories' => ['ciclismo', 'actividades-parques', 'reservas-naturales']
        ],
        'ciclismo' => [
            'name' => 'Ciclismo',
            'emoji' => '🚵',
            'hero_image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Pedaleando por montañas, páramos y caminos que inspiran',
            'accent_color' => '#22c55e', // green
            'type' => 'Turismo',
            'description' => 'Rutas ciclistas que atraviesan paisajes variados desde montañas hasta valles y costas.',
            'related_categories' => ['deportes-aventura', 'actividades-parques', 'reservas-naturales']
        ],
        'actividades-parques' => [
            'name' => 'Actividades en parques',
            'emoji' => '🏞️',
            'hero_image' => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Aventura y diversión en los espacios naturales más protegidos',
            'accent_color' => '#10b981', // emerald
            'type' => 'Turismo',
            'description' => 'Recorridos guiados y actividades educativas en parques nacionales y reservas naturales.',
            'related_categories' => ['deportes-aventura', 'ciclismo', 'reservas-naturales']
        ],

        // Cultural
        'museos' => [
            'name' => 'Museos',
            'emoji' => '🏛️',
            'hero_image' => 'https://images.unsplash.com/photo-1564479221317-68f874e75c84?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Historia, arte y cultura colombiana bajo el mismo techo',
            'accent_color' => '#7c3aed', // purple
            'type' => 'Cultural',
            'description' => 'Espacios que preservan y exhiben el patrimonio histórico, artístico y cultural de Colombia.',
            'related_categories' => ['iglesias', 'fiestas-ferias', 'regiones']
        ],
        'iglesias' => [
            'name' => 'Iglesias',
            'emoji' => '⛪',
            'hero_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Joyas coloniales que cuentan siglos de fe y arquitectura',
            'accent_color' => '#a855f7', // violet
            'type' => 'Cultural',
            'description' => 'Templos coloniales y arquitectura religiosa que representan siglos de historia y fe.',
            'related_categories' => ['museos', 'fiestas-ferias', 'regiones']
        ],
        'regiones' => [
            'name' => 'Regiones',
            'emoji' => '🗺️',
            'hero_image' => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'La diversidad de Colombia en sus territorios y paisajes únicos',
            'accent_color' => '#6366f1', // indigo
            'type' => 'Geográfica',
            'description' => 'Regiones geográficas distintas con ecosistemas, culturas y paisajes característicos.',
            'related_categories' => ['museos', 'iglesias', 'fiestas-ferias']
        ],

        // Fiestas y Eventos
        'fiestas-ferias' => [
            'name' => 'Fiestas y ferias',
            'emoji' => '🎉',
            'hero_image' => 'https://images.unsplash.com/photo-1527864550417-7fd9fc9048c8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Colombia celebra con música, color y tradición todo el año',
            'accent_color' => '#ec4899', // pink
            'type' => 'Cultural',
            'description' => 'Festividades tradicionales que muestran la cultura, música y alegría colombiana.',
            'related_categories' => ['museos', 'iglesias', 'eventos']
        ],
        'eventos' => [
            'name' => 'Eventos',
            'emoji' => '📅',
            'hero_image' => 'https://images.unsplash.com/photo-1464207687429-7505649dae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Encuentros que celebran la cultura, arte y vida colombiana',
            'accent_color' => '#f43f5e', // rose
            'type' => 'Cultural',
            'description' => 'Eventos culturales, artísticos y sociales que dinamizan la vida colombiana.',
            'related_categories' => ['fiestas-ferias', 'museos', 'iglesias']
        ],

        // Gastronomía
        'platos-tipicos' => [
            'name' => 'Platos típicos',
            'emoji' => '🍽️',
            'hero_image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Sabores que cuentan la historia de Colombia en cada bocado',
            'accent_color' => '#dc2626', // red
            'type' => 'Gastronomía',
            'description' => 'Platos tradicionales que representan la diversidad culinaria de cada región.',
            'related_categories' => ['gastronomia', 'categorias-gastronomicas', 'bebidas-tipicas']
        ],
        'gastronomia' => [
            'name' => 'Gastronomía',
            'emoji' => '🍴',
            'hero_image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'La cocina colombiana fusión de sabores, tradición y creatividad',
            'accent_color' => '#ea580c', // orange
            'type' => 'Gastronomía',
            'description' => 'Experiencias culinarias que combinan ingredientes locales con técnicas tradicionales.',
            'related_categories' => ['platos-tipicos', 'categorias-gastronomicas', 'bebidas-tipicas']
        ],
        'categorias-gastronomicas' => [
            'name' => 'Categorías gastronómicas',
            'emoji' => '👨‍🍳',
            'hero_image' => 'https://images.unsplash.com/photo-1556910102-1a93e825b0d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'De la costa al interior, una geografía de sabores únicos',
            'accent_color' => '#f59e0b', // amber
            'type' => 'Gastronomía',
            'description' => 'Clasificación de la cocina colombiana por regiones, ingredientes y técnicas.',
            'related_categories' => ['platos-tipicos', 'gastronomia', 'bebidas-tipicas']
        ],
        'bebidas-tipicas' => [
            'name' => 'Bebidas típicas',
            'emoji' => '🥤',
            'hero_image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Refrescos tradicionales que refrescan el alma colombiana',
            'accent_color' => '#0ea5e9', // sky blue
            'type' => 'Gastronomía',
            'description' => 'Bebidas tradicionales elaboradas con frutas locales y recetas ancestrales.',
            'related_categories' => ['platos-tipicos', 'gastronomia', 'categorias-gastronomicas']
        ],

        // Alojamiento
        'alojamiento' => [
            'name' => 'Alojamiento',
            'emoji' => '🏨',
            'hero_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Hospedaje cómodo y auténtico para disfrutar Colombia',
            'accent_color' => '#059669', // emerald
            'type' => 'Servicios',
            'description' => 'Opciones de hospedaje que van desde hoteles de lujo hasta alojamientos rurales.',
            'related_categories' => ['casas-huespedes', 'eco-lodges', 'resorts']
        ],
        'casas-huespedes' => [
            'name' => 'Casas de huéspedes',
            'emoji' => '🏠',
            'hero_image' => 'https://images.unsplash.com/photo-1611892443774-2cc3b5c4ce2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'El calor de hogar colombiano en cada estancia',
            'accent_color' => '#84cc16', // lime
            'type' => 'Servicios',
            'description' => 'Alojamientos familiares que ofrecen hospitalidad y experiencia local auténtica.',
            'related_categories' => ['alojamiento', 'eco-lodges', 'resorts']
        ],
        'eco-lodges' => [
            'name' => 'Eco-Lodges',
            'emoji' => '🌳',
            'hero_image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Alojamiento sostenible en armonía con la naturaleza',
            'accent_color' => '#16a34a', // green
            'type' => 'Servicios',
            'description' => 'Refugios ecológicos diseñados para minimizar el impacto ambiental.',
            'related_categories' => ['alojamiento', 'casas-huespedes', 'resorts']
        ],
        'resorts' => [
            'name' => 'Resorts',
            'emoji' => '🏖️',
            'hero_image' => 'https://images.unsplash.com/photo-1582719508461-9052002a3230?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Lujo y confort en los destinos más exclusivos',
            'accent_color' => '#0891b2', // cyan
            'type' => 'Servicios',
            'description' => 'Complejos turísticos de lujo con servicios completos y experiencias premium.',
            'related_categories' => ['alojamiento', 'casas-huespedes', 'eco-lodges']
        ],

        // Entretenimiento
        'parques-tematicos' => [
            'name' => 'Parques temáticos',
            'emoji' => '🎢',
            'hero_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Diversión y aventura para toda la familia',
            'accent_color' => '#8b5cf6', // violet
            'type' => 'Turismo',
            'description' => 'Parques con atracciones temáticas que ofrecen entretenimiento y emociones fuertes.',
            'related_categories' => ['deportes-aventura', 'actividades-parques', 'eventos']
        ],
        'agencias-viajes' => [
            'name' => 'Agencias de viajes',
            'emoji' => '✈️',
            'hero_image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Expertos que guían tus aventuras colombianas',
            'accent_color' => '#3b82f6', // blue
            'type' => 'Servicios',
            'description' => 'Servicios profesionales para planificar y organizar viajes por Colombia.',
            'related_categories' => ['alojamiento', 'rutas-turisticas', 'destinos']
        ],
        'rutas-turisticas' => [
            'name' => 'Rutas turísticas',
            'emoji' => '🗺️',
            'hero_image' => 'https://images.unsplash.com/photo-1551969034-7d9e2092a0d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Caminos que narran historias y descubren tesoros',
            'accent_color' => '#f59e0b', // amber
            'type' => 'Turismo',
            'description' => 'Rutas diseñadas para explorar los mejores destinos y experiencias colombianas.',
            'related_categories' => ['destinos', 'agencias-viajes', 'regiones']
        ],
        'destinos' => [
            'name' => 'Destinos',
            'emoji' => '📍',
            'hero_image' => 'https://images.unsplash.com/photo-1512458872269-b63f40c78571?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'tagline' => 'Lugares inolvidables que definen la esencia de Colombia',
            'accent_color' => '#ef4444', // red
            'type' => 'Turismo',
            'description' => 'Sitios turísticos destacados que ofrecen experiencias únicas e inolvidables.',
            'related_categories' => ['rutas-turisticas', 'agencias-viajes', 'regiones']
        ]
    ],

    // Group categories by type for easy navigation
    'category_groups' => [
        'Naturaleza' => ['islas', 'termales', 'playas', 'reservas-naturales', 'desiertos-lagunas'],
        'Turismo' => ['deportes-aventura', 'ciclismo', 'actividades-parques', 'parques-tematicos', 'rutas-turisticas', 'destinos'],
        'Cultural' => ['museos', 'iglesias', 'fiestas-ferias', 'eventos'],
        'Gastronomía' => ['platos-tipicos', 'gastronomia', 'categorias-gastronomicas', 'bebidas-tipicas'],
        'Geográfica' => ['regiones'],
        'Servicios' => ['alojamiento', 'casas-huespedes', 'eco-lodges', 'resorts', 'agencias-viajes']
    ]
];
