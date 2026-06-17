@extends('layouts.modern')

@section('title', 'Diseño Moderno')

@section('content')
<style>
    .hero {
        position: relative;
        height: 500px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 48px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 48px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.9) 0%, rgba(245, 158, 11, 0.85) 100%);
        color: white;
    }

    .hero-title {
        font-family: 'Inter', sans-serif;
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 24px;
        line-height: 1.1;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .stat {
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        padding: 12px 20px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .stat:hover {
        background: rgba(255,255,255,0.35);
        transform: translateY(-4px);
    }

    .stat i {
        font-size: 1.25rem;
    }

    .stat strong {
        font-size: 1.1rem;
    }
</style>

<!-- Hero Section -->
<div class="hero" style="background: linear-gradient(135deg, #0f2d1a 0%, #10b981 50%, #059669 100%);">
    <div class="hero-content">
        <h1 class="hero-title font-display">Descubre Colombia</h1>
        <p class="text-xl" style="margin-bottom: 2rem; opacity: 0.95;">Un paraíso de aventuras, cultura y paisajes increíbles te esperan</p>
        <div class="hero-stats">
            <div class="stat">
                <i class="fas fa-map-marked-alt"></i>
                <strong>156</strong> Destinos
            </div>
            <div class="stat">
                <i class="fas fa-hiking"></i>
                <strong>89</strong> Actividades
            </div>
            <div class="stat">
                <i class="fas fa-bed"></i>
                <strong>234</strong> Alojamientos
            </div>
            <div class="stat">
                <i class="fas fa-calendar-alt"></i>
                <strong>45</strong> Eventos
            </div>
        </div>
    </div>
</div>

<!-- Destinos Destacados -->
<section style="margin-bottom: 4rem;">
    <h2 class="text-4xl font-display" style="margin-bottom: 2rem; color: var(--dark);">Destinos increíbles</h2>
    <div class="grid grid-auto">
        <!-- Cartagena -->
        <div class="card">
            <div class="card-image" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);">
                <div class="card-overlay"></div>
                <div class="card-badge">Ciudad Histórica</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.8</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-display">Cartagena de Indias</h3>
                <p class="card-description">Joyas del Caribe con murallas coloniales, calles empedradas y playas paradisíacas que te transportarán a otra época.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Bolívar</span>
                    <span><i class="fas fa-umbrella-beach"></i> Playa</span>
                    <span><i class="fas fa-landmark"></i> Histórico</span>
                </div>
            </div>
        </div>

        <!-- Medellín -->
        <div class="card">
            <div class="card-image" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);">
                <div class="card-overlay"></div>
                <div class="card-badge">Ciudad Moderna</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.7</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-display">Medellín</h3>
                <p class="card-description">Ciudad de la eterna primavera con innovación, cultura, ferias y el clima perfecto para explorar sus maravillas.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Antioquia</span>
                    <span><i class="fas fa-city"></i> Urbana</span>
                    <span><i class="fas fa-temperature-high"></i> 22°C</span>
                </div>
            </div>
        </div>

        <!-- Santa Marta -->
        <div class="card">
            <div class="card-image" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);">
                <div class="card-overlay"></div>
                <div class="card-badge">Puerto Turístico</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.6</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-display">Santa Marta</h3>
                <p class="card-description">Primera ciudad de Colombia con acceso a Sierra Nevada, Tayrona y las mejores playas del Caribe.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Magdalena</span>
                    <span><i class="fas fa-mountain"></i> Montaña</span>
                    <span><i class="fas fa-water"></i> Mar</span>
                </div>
            </div>
        </div>

        <!-- Eje Cafetero -->
        <div class="card">
            <div class="card-image" style="background: linear-gradient(135deg, #92400e 0%, #78350f 50%, #451a03 100%);">
                <div class="card-overlay"></div>
                <div class="card-badge">Cultura Cafetera</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.9</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-display">Eje Cafetero</h3>
                <p class="card-description">Haciendas cafeteras, paisajes verdes, cultura del café y la gente más amable que encontrarás.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Caldas</span>
                    <span><i class="fas fa-coffee"></i> Café</span>
                    <span><i class="fas fa-leaf"></i> Verde</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Explorar por Tipo -->
<section style="margin-bottom: 4rem;">
    <h2 class="text-4xl font-display" style="margin-bottom: 2rem; color: var(--dark);">Explora por tipo</h2>
    <div class="grid grid-4x4">
        <!-- Playas -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">🏖️ Playas</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">24 destinos paradisíacos</p>
            </div>
        </div>

        <!-- Montañas -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #64748b 0%, #475569 50%, #334155 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">🏔️ Montañas</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">18 picos impresionantes</p>
            </div>
        </div>

        <!-- Cultura -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">🏛️ Cultura</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">32 sitios históricos</p>
            </div>
        </div>

        <!-- Aventura -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">🎯 Aventura</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">28 experiencias únicas</p>
            </div>
        </div>

        <!-- Gastronomía -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">🍽️ Gastronomía</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">15 platos típicos</p>
            </div>
        </div>

        <!-- Naturaleza -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">🌿 Naturaleza</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">22 parques naturales</p>
            </div>
        </div>

        <!-- Historia -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #78716c 0%, #57534e 50%, #44403c 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">📚 Historia</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">19 museos importantes</p>
            </div>
        </div>

        <!-- Relax -->
        <div class="card">
            <div class="card-image" style="height: 160px; background: linear-gradient(135deg, #a855f7 0%, #9333ea 50%, #7e22ce 100%);">
                <div class="card-overlay"></div>
            </div>
            <div class="card-content" style="padding: 1.5rem;">
                <h3 class="card-title font-display" style="font-size: 1.25rem;">🧘 Relax</h3>
                <p class="text-sm" style="color: var(--gray); margin: 0;">12 spas y termales</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section style="text-align: center; padding: 4rem 0;">
    <div style="background: var(--gradient-primary); border-radius: var(--radius-lg); padding: 3rem; color: white; box-shadow: var(--shadow-2xl);">
        <h2 class="text-3xl font-display" style="margin-bottom: 1rem;">¿Listo para tu aventura?</h2>
        <p class="text-lg" style="margin-bottom: 2rem; opacity: 0.9;">Explora los destinos más increíbles de Colombia y vive experiencias inolvidables</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <button class="btn" style="background: white; color: var(--primary);">
                <i class="fas fa-search"></i>
                Explorar destinos
            </button>
            <button class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid white;">
                <i class="fas fa-play"></i>
                Ver videos
            </button>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Modern design test loaded');
    
    // Animate hero content
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        heroContent.style.opacity = '0';
        heroContent.style.transform = 'translateY(50px)';
        setTimeout(() => {
            heroContent.style.transition = 'all 1s ease-out';
            heroContent.style.opacity = '1';
            heroContent.style.transform = 'translateY(0)';
        }, 300);
    }
    
    // Animate stats
    const stats = document.querySelectorAll('.stat');
    stats.forEach((stat, index) => {
        stat.style.opacity = '0';
        stat.style.transform = 'translateY(20px)';
        setTimeout(() => {
            stat.style.transition = 'all 0.6s ease-out';
            stat.style.opacity = '1';
            stat.style.transform = 'translateY(0)';
        }, 1000 + (index * 200));
    });
});
</script>
@endpush
@endsection
