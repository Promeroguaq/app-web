@extends('layouts.design-system')

@section('title', 'Dashboard')

@section('content')
<!-- Hero Section -->
<div class="hero" style="background: linear-gradient(135deg, #0f2d1a 0%, #10b981 50%, #059669 100%);">
    <div class="hero-content">
        <h1 class="hero-title font-serif">Descubre Colombia</h1>
        <div class="hero-stats">
            <div class="stat-pill">
                <i class="fas fa-map-marked-alt"></i>
                <strong>156</strong> Destinos
            </div>
            <div class="stat-pill">
                <i class="fas fa-hiking"></i>
                <strong>89</strong> Actividades
            </div>
            <div class="stat-pill">
                <i class="fas fa-bed"></i>
                <strong>234</strong> Alojamientos
            </div>
            <div class="stat-pill">
                <i class="fas fa-calendar-alt"></i>
                <strong>45</strong> Eventos
            </div>
        </div>
    </div>
</div>

<!-- Destinos Destacados -->
<section style="margin-bottom: 48px;">
    <h2 class="text-3xl font-serif" style="margin-bottom: 24px;">Destinos destacados</h2>
    <div class="grid-2x4">
        <!-- Carta 1 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Ciudad Histórica</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.8</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">Cartagena de Indias</h3>
                <p class="card-description">Joyas del Caribe con murallas coloniales y playas paradisíacas.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Bolívar</span>
                    <span><i class="fas fa-umbrella-beach"></i> Playa</span>
                </div>
            </div>
        </div>

        <!-- Carta 2 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Ciudad Moderna</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.7</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">Medellín</h3>
                <p class="card-description">Ciudad de la eterna primavera con innovación y cultura.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Antioquia</span>
                    <span><i class="fas fa-city"></i> Urbana</span>
                </div>
            </div>
        </div>

        <!-- Carta 3 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Puerto Turístico</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.6</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">Santa Marta</h3>
                <p class="card-description">Primera ciudad de Colombia con acceso a Sierra Nevada y Tayrona.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Magdalena</span>
                    <span><i class="fas fa-mountain"></i> Montaña</span>
                </div>
            </div>
        </div>

        <!-- Carta 4 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #92400e 0%, #78350f 50%, #451a03 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Cultura Cafetera</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.9</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">Eje Cafetero</h3>
                <p class="card-description">Haciendas cafeteras, paisajes verdes y cultura del café.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Caldas</span>
                    <span><i class="fas fa-coffee"></i> Café</span>
                </div>
            </div>
        </div>

        <!-- Carta 5 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Capital</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.5</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">Bogotá</h3>
                <p class="card-description">Corazón de Colombia con museos, gastronomía y cultura.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Cundinamarca</span>
                    <span><i class="fas fa-landmark"></i> Cultural</span>
                </div>
            </div>
        </div>

        <!-- Carta 6 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Isla Caribeña</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.8</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">San Andrés</h3>
                <p class="card-description">Paraíso caribeño con playas de arena blanca y mar cristalino.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Archipiélago</span>
                    <span><i class="fas fa-umbrella-beach"></i> Playa</span>
                </div>
            </div>
        </div>

        <!-- Carta 7 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Capital de la Salsa</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.4</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">Cali</h3>
                <p class="card-description">Ritmo, sabor y alegría en la capital mundial de la salsa.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Valle del Cauca</span>
                    <span><i class="fas fa-music"></i> Música</span>
                </div>
            </div>
        </div>

        <!-- Carta 8 -->
        <div class="card card-group">
            <div class="card-image" style="height: 200px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 50%, #4d7c0f 100%);">
                <div class="card-gradient"></div>
                <div class="card-badge">Puerta de los Llanos</div>
                <div class="card-rating">
                    <span class="star">★</span>
                    <strong>4.3</strong>
                </div>
            </div>
            <div class="card-content">
                <h3 class="card-title font-serif">Villavicencio</h3>
                <p class="card-description">Cultura llanera, cabalgatas y paisajes de la sabana.</p>
                <div class="card-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Meta</span>
                    <span><i class="fas fa-horse"></i> Llano</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Explorar por tipo -->
<section style="margin-bottom: 48px;">
    <h2 class="text-3xl font-serif" style="margin-bottom: 24px;">Explorar por tipo</h2>
    <div class="grid-4-cols">
        <!-- Playas -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">🏖️ Playas</h3>
                <p class="text-sm text-secondary" style="margin: 0;">24 destinos</p>
            </div>
        </div>

        <!-- Montañas -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #64748b 0%, #475569 50%, #334155 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">🏔️ Montañas</h3>
                <p class="text-sm text-secondary" style="margin: 0;">18 destinos</p>
            </div>
        </div>

        <!-- Cultura -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">🏛️ Cultura</h3>
                <p class="text-sm text-secondary" style="margin: 0;">32 destinos</p>
            </div>
        </div>

        <!-- Aventura -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">🎯 Aventura</h3>
                <p class="text-sm text-secondary" style="margin: 0;">28 destinos</p>
            </div>
        </div>

        <!-- Gastronomía -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">🍽️ Gastronomía</h3>
                <p class="text-sm text-secondary" style="margin: 0;">15 destinos</p>
            </div>
        </div>

        <!-- Naturaleza -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">🌿 Naturaleza</h3>
                <p class="text-sm text-secondary" style="margin: 0;">22 destinos</p>
            </div>
        </div>

        <!-- Historia -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #78716c 0%, #57534e 50%, #44403c 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">📚 Historia</h3>
                <p class="text-sm text-secondary" style="margin: 0;">19 destinos</p>
            </div>
        </div>

        <!-- Relax -->
        <div class="card card-group">
            <div class="card-image" style="height: 120px; background: linear-gradient(135deg, #a855f7 0%, #9333ea 50%, #7e22ce 100%);">
                <div class="card-gradient"></div>
            </div>
            <div class="card-content" style="padding: 16px;">
                <h3 class="card-title font-serif" style="font-size: 1rem;">🧘 Relax</h3>
                <p class="text-sm text-secondary" style="margin: 0;">12 destinos</p>
            </div>
        </div>
    </div>
</section>

<!-- Publicidad -->
<section>
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 32px; margin-bottom: 32px; text-align: center; color: white;">
        <div style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); padding: 8px 16px; border-radius: 9999px; display: inline-block; margin-bottom: 16px; font-size: 0.75rem; font-weight: 500;">
            Patrocinado
        </div>
        <h3 class="text-2xl font-serif" style="margin-bottom: 8px;">Descubre los mejores tours</h3>
        <p style="margin-bottom: 20px; opacity: 0.9;">Reserva tus aventuras con descuentos exclusivos</p>
        <button class="btn" style="background: white; color: #667eea;">
            Ver ofertas
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>

    <div class="grid-responsive">
        <!-- Sponsor 1 -->
        <div class="card">
            <div class="card-content" style="text-align: center;">
                <div style="width: 60px; height: 60px; background: #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 1.5rem;">
                    ✈️
                </div>
                <h4 class="card-title" style="font-size: 1rem;">Viaja Colombia</h4>
                <p class="text-sm" style="color: var(--text-secondary);">Tours aéreos y terrestres</p>
            </div>
        </div>

        <!-- Sponsor 2 -->
        <div class="card">
            <div class="card-content" style="text-align: center;">
                <div style="width: 60px; height: 60px; background: #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 1.5rem;">
                    🏨
                </div>
                <h4 class="card-title" style="font-size: 1rem;">Hoteles Plus</h4>
                <p class="text-sm" style="color: var(--text-secondary);">Alojamiento premium</p>
            </div>
        </div>

        <!-- Sponsor 3 -->
        <div class="card">
            <div class="card-content" style="text-align: center;">
                <div style="width: 60px; height: 60px; background: #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 1.5rem;">
                    🎒
                </div>
                <h4 class="card-title" style="font-size: 1rem;">Adventure Gear</h4>
                <p class="text-sm" style="color: var(--text-secondary);">Equipamiento deportivo</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Dashboard con design system cargado');
    
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
@endsection
