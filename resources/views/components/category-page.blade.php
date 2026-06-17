@php
    use Illuminate\Support\Facades\Config;
    
    // Get category configuration
    $categoryKey = $categoryKey ?? 'playas';
    $categoryConfig = Config::get("categories.categories.{$categoryKey}");
    
    if (!$categoryConfig) {
        // Fallback configuration
        $categoryConfig = [
            'name' => ucfirst($categoryKey),
            'emoji' => '📍',
            'hero_gradient' => 'linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%)',
            'tagline' => 'Descubre los mejores destinos de Colombia',
            'accent_color' => '#059669',
            'type' => 'Turismo',
            'description' => 'Explora increíbles lugares en Colombia',
            'related_categories' => []
        ];
    }
@endphp

<style>
    /* =========================
       CATEGORY PAGE MODERN STYLE
    ========================== */
    
    .category-hero {
        position: relative;
        height: 420px;
        margin: -20px -24px 40px -24px;
        overflow: hidden;
        border-radius: 0;
    }

    .category-hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ $categoryConfig['hero_image'] }}');
        background-size: cover;
        background-position: center;
        z-index: 1;
    }

    .category-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
        z-index: 2;
    }

    .category-hero-content {
        position: relative;
        z-index: 3;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        padding: 2rem;
    }

    .category-hero-emoji {
        font-size: 80px;
        margin-bottom: 1rem;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
    }

    .category-hero-title {
        font-family: 'Fraunces', serif;
        font-size: 56px;
        font-weight: 700;
        margin-bottom: 1rem;
        color: white;
        line-height: 1.1;
    }

    .category-hero-tagline {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 20px;
        color: rgba(255,255,255,0.95);
        margin-bottom: 2rem;
        max-width: 700px;
        line-height: 1.6;
    }

    .category-hero-count {
        background: {{ $categoryConfig['accent_color'] }};
        color: white;
        padding: 12px 24px;
        border-radius: 50px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* =========================
       STATS SECTION
    ========================== */

    .stats-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
        padding: 0 24px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: {{ $categoryConfig['accent_color'] }};
        margin-bottom: 8px;
        font-family: 'Fraunces', serif;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 16px;
        color: #374151;
        margin-top: 8px;
        font-weight: 500;
    }

    /* =========================
       DESTINATIONS CARDS
    ========================== */

    .destinations-large {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 32px;
        margin-bottom: 48px;
        padding: 0 24px;
    }

    .destination-card-large {
        border-radius: 20px;
        border: none;
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        background: white;
        position: relative;
        height: 400px;
    }

    .destination-card-large:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }

    .destination-card-large:hover .destination-image img{
        transform: scale(1.05);
    }

    .destination-image {
        position: relative;
        height: 260px;
        overflow: hidden;
    }

    .destination-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .destination-rating {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.875rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .destination-rating i {
        color: #fbbf24;
        font-size: 14px;
    }

    .destination-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
        padding: 24px;
        z-index: 2;
    }

    .destination-name {
        color: white;
        font-family: 'Fraunces', serif;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .destination-location {
        color: rgba(255,255,255,0.8);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .destinations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 48px;
        padding: 0 24px;
    }

    .destination-card-compact {
        border-radius: 16px;
        border: none;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transition: all 0.3s ease;
        overflow: hidden;
        background: white;
        position: relative;
        height: 280px;
    }

    .destination-card-compact:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    }

    .destination-card-compact .destination-image {
        height: 180px;
    }

    .destination-card-compact .destination-name {
        font-size: 18px;
        margin-bottom: 4px;
    }

    .destination-card-compact .destination-location {
        font-size: 12px;
    }

    /* =========================
       EMPTY STATE
    ========================== */

    .empty-state {
        text-align: center;
        padding: 80px 24px;
        background: white;
        border-radius: 20px;
        margin: 0 24px 48px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .empty-state-emoji {
        font-size: 80px;
        margin-bottom: 24px;
        opacity: 0.6;
    }

    .empty-state-title {
        font-family: 'Fraunces', serif;
        font-size: 28px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 12px;
    }

    .empty-state-description {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 32px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-explore {
        background: {{ $categoryConfig['accent_color'] }};
        border: none;
        color: white;
        padding: 14px 32px;
        border-radius: 50px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 16px;
        box-shadow: 0 4px 15px {{ $categoryConfig['accent_color'] }}33;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-explore:hover {
        background: {{ $categoryConfig['accent_color'] }}dd;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px {{ $categoryConfig['accent_color'] }}66;
        color: white;
    }

    /* =========================
       EXPLORE MORE SECTION
    ========================== */

    .explore-more-section {
        padding: 48px 24px;
        background: #f9fafb;
        border-radius: 20px;
        margin: 0 24px;
    }

    .explore-more-title {
        font-family: 'Fraunces', serif;
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 24px;
        text-align: center;
    }

    .explore-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        justify-content: center;
    }

    .explore-chip {
        background: white;
        border: 2px solid #e5e7eb;
        color: #374151;
        padding: 12px 24px;
        border-radius: 50px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .explore-chip:hover {
        border-color: {{ $categoryConfig['accent_color'] }};
        color: {{ $categoryConfig['accent_color'] }};
        transform: translateY(-2px);
        box-shadow: 0 4px 12px {{ $categoryConfig['accent_color'] }}33;
    }

    .explore-chip i {
        font-size: 16px;
    }
</style>

<div class="container-fluid px-0">

    <!-- Hero Section -->
    <div class="category-hero">
        <div class="category-hero-background"></div>
        <div class="category-hero-overlay"></div>
        <div class="category-hero-content">
            <div class="category-hero-emoji">{{ $categoryConfig['emoji'] }}</div>
            <h1 class="category-hero-title">{{ $categoryConfig['name'] }}</h1>
            <p class="category-hero-tagline">{{ $categoryConfig['tagline'] }}</p>
            <div class="category-hero-count">
                <i class="fas fa-map-marker-alt"></i> 
                <span id="destinations-count">{{ $items->count() ?? 0 }}</span> destinos registrados
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-number" id="registered-count">{{ $items->count() ?? 0 }}</div>
            <div class="stat-label">Destinos Registrados</div>
            <div class="stat-value">{{ $categoryConfig['name'] }} certificadas y accesibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $categoryConfig['type'] }}</div>
            <div class="stat-label">Tipo</div>
            <div class="stat-value">{{ $categoryConfig['type'] == 'Naturaleza' ? 'Destinos naturales protegidos' : ($categoryConfig['type'] == 'Cultural' ? 'Patrimonio cultural colombiano' : ($categoryConfig['type'] == 'Gastronomía' ? 'Experiencias culinarias únicas' : 'Servicios turísticos premium')) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $categoryConfig['emoji'] }}</div>
            <div class="stat-label">Descripción</div>
            <div class="stat-value">{{ $categoryConfig['description'] }}</div>
        </div>
    </div>

    <!-- Destinos Section -->
    @if(isset($items) && $items->count() > 0)
        @if($items->count() >= 3)
            <!-- Large Cards for first 3 -->
            <div class="destinations-large">
                @foreach($items->take(3) as $item)
                    <div class="destination-card-large">
                        <div class="destination-image">
                            @if(isset($item->imagen) && !empty($item->imagen))
                                <img src="{{ $item->imagen }}" 
                                     alt="{{ $item->nombre ?? $categoryConfig['name'] }}" 
                                     loading="lazy"
                                     onerror="this.src='{{ $categoryConfig['hero_image'] }}';">
                            @else
                                <img src="{{ $categoryConfig['hero_image'] }}" 
                                     alt="{{ $categoryConfig['name'] }}" 
                                     loading="lazy">
                            @endif
                            
                            <div class="destination-rating">
                                <i class="fas fa-star"></i> {{ number_format(4.5 + rand(1, 8) / 10, 1) }}
                            </div>
                            
                            <div class="destination-overlay">
                                <h3 class="destination-name">{{ $item->nombre ?? $item->NOMBRE_ACTIVIDAD_EN_PARQUE ?? $item->nombre_desierto_lagunas ?? $item->NOMBRE_ISLA ?? $item->nombre_museo ?? $item->nombre_iglesia ?? $item->nombre_parque ?? $item->nombre ?? $categoryConfig['name'] . ' Destacado' }}</h3>
                                <p class="destination-location">
                                    <i class="fas fa-map-marker-alt"></i> 
                                    {{ $item->ubicacion ?? $item->departamento ?? $item->region ?? 'Colombia' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($items->count() > 3)
                <!-- Grid for remaining destinations -->
                <div class="destinations-grid">
                    @foreach($items->skip(3) as $item)
                        <div class="destination-card-compact">
                            <div class="destination-image">
                                @if(isset($item->imagen) && !empty($item->imagen))
                                    <img src="{{ $item->imagen }}" 
                                         alt="{{ $item->nombre ?? $categoryConfig['name'] }}" 
                                         loading="lazy"
                                         onerror="this.src='{{ $categoryConfig['hero_image'] }}';">
                                @else
                                    <img src="{{ $categoryConfig['hero_image'] }}" 
                                         alt="{{ $categoryConfig['name'] }}" 
                                         loading="lazy">
                                @endif
                                
                                <div class="destination-rating">
                                    <i class="fas fa-star"></i> {{ number_format(4.2 + rand(1, 8) / 10, 1) }}
                                </div>
                                
                                <div class="destination-overlay">
                                    <h4 class="destination-name">{{ $item->nombre ?? $item->NOMBRE_ACTIVIDAD_EN_PARQUE ?? $item->nombre_desierto_lagunas ?? $item->NOMBRE_ISLA ?? $item->nombre_museo ?? $item->nombre_iglesia ?? $item->nombre_parque ?? $item->nombre ?? $categoryConfig['name'] . ' Tropical' }}</h4>
                                    <p class="destination-location">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        {{ $item->ubicacion ?? $item->departamento ?? $item->region ?? 'Colombia' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <!-- Grid for less than 3 destinations -->
            <div class="destinations-grid">
                @foreach($items as $item)
                    <div class="destination-card-compact">
                        <div class="destination-image">
                            @if(isset($item->imagen) && !empty($item->imagen))
                                <img src="{{ $item->imagen }}" 
                                     alt="{{ $item->nombre ?? $categoryConfig['name'] }}" 
                                     loading="lazy"
                                     onerror="this.src='{{ $categoryConfig['hero_image'] }}';">
                            @else
                                <img src="{{ $categoryConfig['hero_image'] }}" 
                                     alt="{{ $categoryConfig['name'] }}" 
                                     loading="lazy">
                            @endif
                            
                            <div class="destination-rating">
                                <i class="fas fa-star"></i> {{ number_format(4.0 + rand(1, 8) / 10, 1) }}
                            </div>
                            
                            <div class="destination-overlay">
                                <h4 class="destination-name">{{ $item->nombre ?? $item->NOMBRE_ACTIVIDAD_EN_PARQUE ?? $item->nombre_desierto_lagunas ?? $item->NOMBRE_ISLA ?? $item->nombre_museo ?? $item->nombre_iglesia ?? $item->nombre_parque ?? $item->nombre ?? $categoryConfig['name'] . ' Hermosa' }}</h4>
                                <p class="destination-location">
                                    <i class="fas fa-map-marker-alt"></i> 
                                    {{ $item->ubicacion ?? $item->departamento ?? $item->region ?? 'Colombia' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-emoji">{{ $categoryConfig['emoji'] }}</div>
            <h2 class="empty-state-title">No hay {{ strtolower($categoryConfig['name']) }} registradas</h2>
            <p class="empty-state-description">
                Pronto encontrarás los mejores {{ strtolower($categoryConfig['name']) }} de Colombia aquí. 
                Mientras tanto, explora otros destinos increíbles.
            </p>
            <a href="/destinos" class="btn-explore">
                <i class="fas fa-compass"></i> 
                Explorar Destinos
            </a>
        </div>
    @endif

    <!-- Explore More Section -->
    @if(!empty($categoryConfig['related_categories']))
        <div class="explore-more-section">
            <h2 class="explore-more-title">Explorar más categorías</h2>
            <div class="explore-chips">
                @foreach($categoryConfig['related_categories'] as $relatedCategoryKey)
                    @php
                        $relatedConfig = Config::get("categories.categories.{$relatedCategoryKey}");
                        if ($relatedConfig):
                    @endphp
                        <a href="/puntos-interes/{{ str_replace('_', '-', $relatedCategoryKey) }}" class="explore-chip">
                            @php
                                $iconClass = 'map-marker-alt';
                                switch($relatedCategoryKey) {
                                    case 'islas':
                                        $iconClass = 'umbrella-beach';
                                        break;
                                    case 'termales':
                                        $iconClass = 'hot-tub';
                                        break;
                                    case 'reservas-naturales':
                                        $iconClass = 'tree';
                                        break;
                                    case 'deportes-aventura':
                                        $iconClass = 'mountain';
                                        break;
                                    case 'ciclismo':
                                        $iconClass = 'biking';
                                        break;
                                    case 'museos':
                                        $iconClass = 'landmark';
                                        break;
                                    case 'iglesias':
                                        $iconClass = 'church';
                                        break;
                                    case 'fiestas-ferias':
                                        $iconClass = 'music';
                                        break;
                                }
                            @endphp
                            <i class="fas fa-{{ $iconClass }}"></i> 
                            {{ $relatedConfig['name'] }} {{ $relatedConfig['emoji'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
// Update counts dynamically
document.addEventListener('DOMContentLoaded', function() {
    @if(isset($items))
        const count = {{ $items->count() }};
        document.getElementById('destinations-count').textContent = count;
        document.getElementById('registered-count').textContent = count;
    @endif
});
</script>
