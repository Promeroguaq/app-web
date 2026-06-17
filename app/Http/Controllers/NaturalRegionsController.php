<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Cache;

class NaturalRegionsController extends Controller
{
    /**
     * Mostrar lista de regiones naturales
     */
    public function index()
    {
        try {
            set_time_limit(120);
            
            $regions = collect([
                (object)[
                    'slug' => 'caribe',
                    'name' => 'Región Caribe',
                    'shortName' => 'Caribe',
                    'subtitle' => 'Playas paradisíacas, cultura caribeña y gastronomía única.',
                    'description' => 'La Región Caribe reúne mar, música, historia, pueblos cálidos y una identidad cultural vibrante.',
                    'departmentCount' => 7,
                    'climate' => 'Cálido',
                    'heroImage' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#facc15',
                    'departments' => collect([
                        (object)['name' => 'La Guajira', 'slug' => 'la-guajira'],
                        (object)['name' => 'Magdalena', 'slug' => 'magdalena'],
                        (object)['name' => 'Atlántico', 'slug' => 'atlantico'],
                        (object)['name' => 'Bolívar', 'slug' => 'bolivar'],
                        (object)['name' => 'Cesar', 'slug' => 'cesar'],
                        (object)['name' => 'Córdoba', 'slug' => 'cordoba'],
                        (object)['name' => 'Sucre', 'slug' => 'sucre']
                    ])
                ],
                (object)[
                    'slug' => 'andina',
                    'name' => 'Región Andina',
                    'shortName' => 'Andina',
                    'subtitle' => 'Montañas, pueblos patrimoniales, café y cultura urbana.',
                    'description' => 'La Región Andina es el corazón de Colombia, donde las montañas, los pueblos coloniales, el café y la cultura urbana se encuentran.',
                    'departmentCount' => 13,
                    'climate' => 'Variado',
                    'heroImage' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#10b981',
                    'departments' => collect([
                        (object)['name' => 'Antioquia', 'slug' => 'antioquia'],
                        (object)['name' => 'Cundinamarca', 'slug' => 'cundinamarca'],
                        (object)['name' => 'Boyacá', 'slug' => 'boyaca'],
                        (object)['name' => 'Caldas', 'slug' => 'caldas'],
                        (object)['name' => 'Risaralda', 'slug' => 'risaralda'],
                        (object)['name' => 'Quindío', 'slug' => 'quindio']
                    ])
                ],
                (object)[
                    'slug' => 'pacifica',
                    'name' => 'Región Pacífica',
                    'shortName' => 'Pacífica',
                    'subtitle' => 'Selva húmeda, ballenas, biodiversidad y cultura afro.',
                    'description' => 'La Región Pacífica es un paraíso de biodiversidad donde la selva húmeda, el avistamiento de ballenas y la cultura afrocolombiana crean una experiencia única.',
                    'departmentCount' => 4,
                    'climate' => 'Húmedo',
                    'heroImage' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#3b82f6',
                    'departments' => collect([
                        (object)['name' => 'Chocó', 'slug' => 'choco'],
                        (object)['name' => 'Valle del Cauca', 'slug' => 'valle-del-cauca'],
                        (object)['name' => 'Cauca', 'slug' => 'cauca'],
                        (object)['name' => 'Nariño', 'slug' => 'narino']
                    ])
                ],
                (object)[
                    'slug' => 'amazonia',
                    'name' => 'Región Amazónica',
                    'shortName' => 'Amazonía',
                    'subtitle' => 'Selva virgen, ríos, biodiversidad y aventura natural.',
                    'description' => 'La Región Amazónica es el pulmón del mundo, donde la selva virgen, los ríos caudalosos y la biodiversidad crean una experiencia de aventura natural inigualable.',
                    'departmentCount' => 6,
                    'climate' => 'Tropical',
                    'heroImage' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#22c55e',
                    'departments' => collect([
                        (object)['name' => 'Amazonas', 'slug' => 'amazonas'],
                        (object)['name' => 'Caquetá', 'slug' => 'caqueta'],
                        (object)['name' => 'Putumayo', 'slug' => 'putumayo'],
                        (object)['name' => 'Guainía', 'slug' => 'guainia'],
                        (object)['name' => 'Guaviare', 'slug' => 'guaviare'],
                        (object)['name' => 'Vaupés', 'slug' => 'vaupes']
                    ])
                ],
                (object)[
                    'slug' => 'llanos',
                    'name' => 'Región Orinoquía',
                    'shortName' => 'Llanos',
                    'subtitle' => 'Sabanas infinitas, cultura llanera y atardeceres.',
                    'description' => 'La Región Orinoquía es un horizonte de sabanas donde la cultura llanera, las cabalgatas, la música y los atardeceres espectaculares definen la identidad.',
                    'departmentCount' => 4,
                    'climate' => 'Tropical seco',
                    'heroImage' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#f97316',
                    'departments' => collect([
                        (object)['name' => 'Arauca', 'slug' => 'arauca'],
                        (object)['name' => 'Casanare', 'slug' => 'casanare'],
                        (object)['name' => 'Meta', 'slug' => 'meta'],
                        (object)['name' => 'Vichada', 'slug' => 'vichada']
                    ])
                ],
                (object)[
                    'slug' => 'insular',
                    'name' => 'Región Insular',
                    'shortName' => 'Insular',
                    'subtitle' => 'Islas caribeñas, arrecifes, buceo y cultura raizal.',
                    'description' => 'La Región Insular es un paraíso de islas caribeñas donde los arrecifes de coral, el buceo, las playas y la cultura raizal crean una experiencia tropical única.',
                    'departmentCount' => 2,
                    'climate' => 'Tropical',
                    'heroImage' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#06b6d4',
                    'departments' => collect([
                        (object)['name' => 'San Andrés y Providencia', 'slug' => 'san-andres-providencia'],
                        (object)['name' => 'Archipiélago de San Bernardo', 'slug' => 'san-bernardo']
                    ])
                ]
            ]);
            
            return view('pages.regiones', compact('regions'));
        } catch (\Exception $e) {
            return view('pages.regiones', [
                'regions' => collect([]),
                'error' => 'Error al cargar regiones naturales: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Mostrar detalle de una región natural
     */
    public function show($slug)
    {
        try {
            set_time_limit(120);
            
            $regions = collect([
                (object)[
                    'slug' => 'caribe',
                    'name' => 'Región Caribe',
                    'shortName' => 'Caribe',
                    'subtitle' => 'Playas paradisíacas, cultura caribeña y gastronomía única.',
                    'description' => 'La Región Caribe reúne mar, música, historia, pueblos cálidos y una identidad cultural vibrante que define el norte de Colombia. Con sus playas de arena blanca, su música contagiosa y su gastronomía rica en sabores del mar, esta región ofrece una experiencia tropical inolvidable.',
                    'departmentCount' => 7,
                    'climate' => 'Cálido',
                    'heroImage' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#facc15',
                    'departments' => [
                        (object)['name' => 'La Guajira', 'slug' => 'la-guajira', 'capital' => 'Riohacha', 'description' => 'Desierto, playas y cultura wayuu.', 'type' => 'department'],
                        (object)['name' => 'Magdalena', 'slug' => 'magdalena', 'capital' => 'Santa Marta', 'description' => 'Sierra Nevada, playas y historia.', 'type' => 'department'],
                        (object)['name' => 'Atlántico', 'slug' => 'atlantico', 'capital' => 'Barranquilla', 'description' => 'Carnaval, cultura y río.', 'type' => 'department'],
                        (object)['name' => 'Bolívar', 'slug' => 'bolivar', 'capital' => 'Cartagena', 'description' => 'Murallas, historia y caribe.', 'type' => 'department'],
                        (object)['name' => 'Cesar', 'slug' => 'cesar', 'capital' => 'Valledupar', 'description' => 'Valle, vallenato y tradición.', 'type' => 'department'],
                        (object)['name' => 'Córdoba', 'slug' => 'cordoba', 'capital' => 'Montería', 'description' => 'Ríos, ganadería y cultura.', 'type' => 'department'],
                        (object)['name' => 'Sucre', 'slug' => 'sucre', 'capital' => 'Sincelejo', 'description' => 'Tradición, festivales y costas.', 'type' => 'department']
                    ],
                    'featuredDestinations' => [
                        (object)['name' => 'Santa Marta', 'slug' => 'santa-marta', 'description' => 'Puerto histórico, Sierra Nevada y playas.', 'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'magdalena'],
                        (object)['name' => 'Barranquilla', 'slug' => 'barranquilla', 'description' => 'Carnaval, cultura y río.', 'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'atlantico'],
                        (object)['name' => 'Parque Tayrona', 'slug' => 'parque-tayrona', 'description' => 'Naturaleza virgen, playas y senderismo.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'place', 'departmentSlug' => 'magdalena', 'municipalitySlug' => 'santa-marta']
                    ],
                    'experiences' => [
                        (object)['title' => 'Playas caribeñas', 'description' => 'Arena, mar cálido y paisajes tropicales.', 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Música y cultura', 'description' => 'Vallenato, cumbia y tradiciones costeñas.', 'image' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Gastronomía costeña', 'description' => 'Pescados, mariscos y sabores del mar.', 'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']
                    ],
                    'gallery' => [
                        'https://images.unsplash.com/photo-1519046904884-53103b34b206?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                (object)[
                    'slug' => 'andina',
                    'name' => 'Región Andina',
                    'shortName' => 'Andina',
                    'subtitle' => 'Montañas, pueblos patrimoniales, café y cultura urbana.',
                    'description' => 'La Región Andina es el corazón de Colombia, donde las montañas, los pueblos coloniales, el café y la cultura urbana se encuentran en un paisaje impresionante.',
                    'departmentCount' => 13,
                    'climate' => 'Variado',
                    'heroImage' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#10b981',
                    'departments' => [
                        (object)['name' => 'Antioquia', 'slug' => 'antioquia', 'capital' => 'Medellín', 'description' => 'Eterna primavera, innovación y cultura.', 'type' => 'department'],
                        (object)['name' => 'Cundinamarca', 'slug' => 'cundinamarca', 'capital' => 'Bogotá', 'description' => 'Capital, museos y gastronomía.', 'type' => 'department'],
                        (object)['name' => 'Boyacá', 'slug' => 'boyaca', 'capital' => 'Tunja', 'description' => 'Historia, pueblos y paisajes.', 'type' => 'department'],
                        (object)['name' => 'Caldas', 'slug' => 'caldas', 'capital' => 'Manizales', 'description' => 'Café, cultura y montañas.', 'type' => 'department'],
                        (object)['name' => 'Risaralda', 'slug' => 'risaralda', 'capital' => 'Pereira', 'description' => 'Café, paisajes y modernidad.', 'type' => 'department'],
                        (object)['name' => 'Quindío', 'slug' => 'quindio', 'capital' => 'Armenia', 'description' => 'Eje cafetero, pueblos y naturaleza.', 'type' => 'department']
                    ],
                    'featuredDestinations' => [
                        (object)['name' => 'Medellín', 'slug' => 'medellin', 'description' => 'Ciudad de la eterna primavera, innovación y cultura.', 'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'antioquia'],
                        (object)['name' => 'Villa de Leyva', 'slug' => 'villa-de-leyva', 'description' => 'Pueblo colonial, historia y paisajes.', 'image' => 'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'boyaca'],
                        (object)['name' => 'Manizales', 'slug' => 'manizales', 'description' => 'Café, cultura y montañas.', 'image' => 'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'caldas']
                    ],
                    'experiences' => [
                        (object)['title' => 'Cultura cafetera', 'description' => 'Haciendas, café y paisajes del Eje Cafetero.', 'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Pueblos patrimoniales', 'description' => 'Arquitectura colonial, historia y tradición.', 'image' => 'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Montañas y miradores', 'description' => 'Paisajes andinos, senderismo y vistas.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']
                    ],
                    'gallery' => [
                        'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1559128010-7c1ad6e1b6a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1596178065887-1198b6148b2b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                (object)[
                    'slug' => 'pacifica',
                    'name' => 'Región Pacífica',
                    'shortName' => 'Pacífica',
                    'subtitle' => 'Selva húmeda, ballenas, biodiversidad y cultura afro.',
                    'description' => 'La Región Pacífica es un paraíso de biodiversidad donde la selva húmeda, el avistamiento de ballenas y la cultura afrocolombiana crean una experiencia única.',
                    'departmentCount' => 4,
                    'climate' => 'Húmedo',
                    'heroImage' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#3b82f6',
                    'departments' => [
                        (object)['name' => 'Chocó', 'slug' => 'choco', 'capital' => 'Quibdó', 'description' => 'Biodiversidad, selva y ríos.', 'type' => 'department'],
                        (object)['name' => 'Valle del Cauca', 'slug' => 'valle-del-cauca', 'capital' => 'Cali', 'description' => 'Salsa, cultura y río Cauca.', 'type' => 'department'],
                        (object)['name' => 'Cauca', 'slug' => 'cauca', 'capital' => 'Popayán', 'description' => 'Patrimonio, religión y tradición.', 'type' => 'department'],
                        (object)['name' => 'Nariño', 'slug' => 'narino', 'capital' => 'Pasto', 'description' => 'Volcanes, cultura y gastronomía.', 'type' => 'department']
                    ],
                    'featuredDestinations' => [
                        (object)['name' => 'Nuquí', 'slug' => 'nuqui', 'description' => 'Playas salvajes, selva y relax.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'choco'],
                        (object)['name' => 'Buenaventura', 'slug' => 'buenaventura', 'description' => 'Puerto del Pacífico, naturaleza y cultura.', 'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'valle-del-cauca'],
                        (object)['name' => 'Popayán', 'slug' => 'popayan', 'description' => 'Ciudad blanca, arquitectura colonial.', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'cauca']
                    ],
                    'experiences' => [
                        (object)['title' => 'Avistamiento de ballenas', 'description' => 'Ballenas jorobadas en su hábitat natural.', 'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Selva húmeda', 'description' => 'Biodiversidad, ríos y naturaleza.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Cultura afrocolombiana', 'description' => 'Música, tradiciones y gastronomía.', 'image' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']
                    ],
                    'gallery' => [
                        'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                (object)[
                    'slug' => 'amazonia',
                    'name' => 'Región Amazónica',
                    'shortName' => 'Amazonía',
                    'subtitle' => 'Selva virgen, ríos, biodiversidad y aventura natural.',
                    'description' => 'La Región Amazónica es el pulmón del mundo, donde la selva virgen, los ríos caudalosos y la biodiversidad crean una experiencia de aventura natural inigualable.',
                    'departmentCount' => 6,
                    'climate' => 'Tropical',
                    'heroImage' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#22c55e',
                    'departments' => [
                        (object)['name' => 'Amazonas', 'slug' => 'amazonas', 'capital' => 'Leticia', 'description' => 'Puerta a la Amazonía, ríos y selva.', 'type' => 'department'],
                        (object)['name' => 'Caquetá', 'slug' => 'caqueta', 'capital' => 'Florencia', 'description' => 'Selva, ríos y naturaleza.', 'type' => 'department'],
                        (object)['name' => 'Putumayo', 'slug' => 'putumayo', 'capital' => 'Mocoa', 'description' => 'Frontera, ríos y cultura.', 'type' => 'department'],
                        (object)['name' => 'Guainía', 'slug' => 'guainia', 'capital' => 'Inírida', 'description' => 'Ríos, estrella fluvial y naturaleza.', 'type' => 'department'],
                        (object)['name' => 'Guaviare', 'slug' => 'guaviare', 'capital' => 'San José del Guaviare', 'description' => 'Arte rupestre, selva y aventura.', 'type' => 'department'],
                        (object)['name' => 'Vaupés', 'slug' => 'vaupes', 'capital' => 'Mitú', 'description' => 'Ríos, selva y comunidades.', 'type' => 'department']
                    ],
                    'featuredDestinations' => [
                        (object)['name' => 'Leticia', 'slug' => 'leticia', 'description' => 'Puerta a la Amazonía, ríos y selva.', 'image' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'amazonas'],
                        (object)['name' => 'Florencia', 'slug' => 'florencia', 'description' => 'Selva, ríos y naturaleza virgen.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'caqueta'],
                        (object)['name' => 'Mocoa', 'slug' => 'mocoa', 'description' => 'Selva, frontera y biodiversidad.', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'putumayo']
                    ],
                    'experiences' => [
                        (object)['title' => 'Selva virgen', 'description' => 'Biodiversidad, flora y fauna.', 'image' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Ríos caudalosos', 'description' => 'Navegación, pesca y aventura.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Comunidades indígenas', 'description' => 'Cultura, tradiciones y conocimiento.', 'image' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']
                    ],
                    'gallery' => [
                        'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                (object)[
                    'slug' => 'llanos',
                    'name' => 'Región Orinoquía',
                    'shortName' => 'Llanos',
                    'subtitle' => 'Sabanas infinitas, cultura llanera y atardeceres.',
                    'description' => 'La Región Orinoquía es un horizonte de sabanas donde la cultura llanera, las cabalgatas, la música y los atardeceres espectaculares definen la identidad de los llanos colombianos.',
                    'departmentCount' => 4,
                    'climate' => 'Tropical seco',
                    'heroImage' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#f97316',
                    'departments' => [
                        (object)['name' => 'Arauca', 'slug' => 'arauca', 'capital' => 'Arauca', 'description' => 'Capital llanera, cultura y tradición.', 'type' => 'department'],
                        (object)['name' => 'Casanare', 'slug' => 'casanare', 'capital' => 'Yopal', 'description' => 'Petróleo, naturaleza y llanos.', 'type' => 'department'],
                        (object)['name' => 'Meta', 'slug' => 'meta', 'capital' => 'Villavicencio', 'description' => 'Puerta a los llanos, aventura.', 'type' => 'department'],
                        (object)['name' => 'Vichada', 'slug' => 'vichada', 'capital' => 'Puerto Carreño', 'description' => 'Frontera, ríos y naturaleza.', 'type' => 'department']
                    ],
                    'featuredDestinations' => [
                        (object)['name' => 'Villavicencio', 'slug' => 'villavicencio', 'description' => 'Puerta a los llanos, naturaleza y tradición.', 'image' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'meta'],
                        (object)['name' => 'Yopal', 'slug' => 'yopal', 'description' => 'Capital llanera, petróleo y cultura.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'casanare'],
                        (object)['name' => 'Arauca', 'slug' => 'arauca', 'description' => 'Capital llanera, ríos y tradición.', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'arauca']
                    ],
                    'experiences' => [
                        (object)['title' => 'Cultura llanera', 'description' => 'Joropo, cabalgatas y tradición.', 'image' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Sabanas infinitas', 'description' => 'Horizontes, naturaleza y libertad.', 'image' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Atardeceres espectaculares', 'description' => 'Cielos pintados, momentos únicos.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']
                    ],
                    'gallery' => [
                        'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ]
                ],
                (object)[
                    'slug' => 'insular',
                    'name' => 'Región Insular',
                    'shortName' => 'Insular',
                    'subtitle' => 'Islas caribeñas, arrecifes, buceo y cultura raizal.',
                    'description' => 'La Región Insular es un paraíso de islas caribeñas donde los arrecifes de coral, el buceo, las playas y la cultura raizal crean una experiencia tropical única.',
                    'departmentCount' => 2,
                    'climate' => 'Tropical',
                    'heroImage' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2340&q=80',
                    'cardImage' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'color' => '#06b6d4',
                    'departments' => [
                        (object)['name' => 'San Andrés y Providencia', 'slug' => 'san-andres-providencia', 'capital' => 'San Andrés', 'description' => 'Isla caribeña, mar de siete colores.', 'type' => 'department'],
                        (object)['name' => 'Archipiélago de San Bernardo', 'slug' => 'san-bernardo', 'capital' => 'Cartagena', 'description' => 'Islas, arrecifes y naturaleza.', 'type' => 'department']
                    ],
                    'featuredDestinations' => [
                        (object)['name' => 'San Andrés', 'slug' => 'san-andres', 'description' => 'Isla caribeña, mar de siete colores.', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'san-andres-providencia'],
                        (object)['name' => 'Providencia', 'slug' => 'providencia', 'description' => 'Naturaleza, buceo y relax.', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'type' => 'municipality', 'departmentSlug' => 'san-andres-providencia']
                    ],
                    'experiences' => [
                        (object)['title' => 'Buceo y snorkel', 'description' => 'Arrecifes, vida marina y aventura.', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Playas caribeñas', 'description' => 'Arena blanca, mar cristalino.', 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
                        (object)['title' => 'Cultura raizal', 'description' => 'Tradiciones, música y hospitalidad.', 'image' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']
                    ],
                    'gallery' => [
                        'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ]
                ]
            ]);
            
            $region = $regions->firstWhere('slug', $slug);
            
            if (!$region) {
                abort(404);
            }
            
            // Cargar imágenes en memoria para departamentos - CACHED
            $imagenes = Cache::remember('imagenes_map_global', 1800, function () {
                return \DB::table('tabla_imagenes')->get();
            });
            $imagenesPorNombre = $imagenes->keyBy(function($img) {
                return ImageHelper::cleanString($img->NOMBRE_IMAGEN);
            });
            
            // Resolver imágenes para departamentos de la región
            $region->departments = collect($region->departments)->map(function($dept) use ($imagenesPorNombre, $region) {
                $nombreNormalizado = ImageHelper::cleanString($dept->name);
                $imagenUrl = null;
                
                if (isset($imagenesPorNombre[$nombreNormalizado])) {
                    $imagenUrl = $imagenesPorNombre[$nombreNormalizado]->RUTA;
                }
                
                // Log para debug
                \Log::info('Imagen departamento en región', [
                    'region' => $region->name,
                    'departamento' => $dept->name,
                    'image_url' => $imagenUrl
                ]);
                
                $dept->image_url = $imagenUrl;
                return $dept;
            });
            
            return view('pages.region-detalle', compact('region'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
