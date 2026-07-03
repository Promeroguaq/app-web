@extends('layouts.premium')

@section('title', 'Inicio')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Barra de búsqueda global -->
<div class="mb-6 md:mb-8">
    <form action="{{ route('buscar') }}" method="GET" class="relative">
        <input 
            type="text" 
            name="q" 
            placeholder="Busca destinos, experiencias, lugares o sabores de Colombia"
            class="w-full px-5 py-4 pl-12 rounded-2xl border border-gray-200 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm md:text-base"
        >
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <button 
            type="submit" 
            class="absolute right-3 top-1/2 -translate-y-1/2 px-4 py-2 bg-emerald-500 text-white rounded-xl text-sm font-medium hover:bg-emerald-600 transition-colors hidden sm:block"
        >
            Buscar
        </button>
    </form>
</div>

<!-- Hero Section - Premium Single Column Layout -->
<div class="relative min-h-[360px] md:min-h-[400px] lg:min-h-[420px] rounded-[36px] mb-8 md:mb-12 overflow-hidden bg-gradient-to-br from-[#07111F] via-[#0B1F2A] to-[#063B32]" style="box-shadow: 0 25px 50px rgba(0,0,0,0.6), 0 50px 100px rgba(0,0,0,0.3), 0 0 0 1px rgba(255,255,255,0.05);">
    <!-- Background Pattern - Subtle Topographic Lines -->
    <div class="absolute inset-0 opacity-[0.03]">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>
    
    <!-- Subtle Glow Effects -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
    
    <!-- Ambient Gold Particles -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute w-2 h-2 bg-[#d97706] rounded-full opacity-30 animate-float hidden md:block" style="top: 15%; left: 10%; animation-delay: 0s; animation-duration: 8s;"></div>
        <div class="absolute w-3 h-3 bg-[#d97706] rounded-full opacity-25 animate-float hidden md:block" style="top: 25%; left: 85%; animation-delay: 1s; animation-duration: 10s;"></div>
        <div class="absolute w-2 h-2 bg-[#d97706] rounded-full opacity-30 animate-float" style="top: 35%; left: 20%; animation-delay: 2s; animation-duration: 9s;"></div>
        <div class="absolute w-3 h-3 bg-[#d97706] rounded-full opacity-20 animate-float hidden md:block" style="top: 45%; left: 75%; animation-delay: 3s; animation-duration: 11s;"></div>
        <div class="absolute w-2 h-2 bg-[#d97706] rounded-full opacity-35 animate-float" style="top: 55%; left: 15%; animation-delay: 4s; animation-duration: 7s;"></div>
        <div class="absolute w-3 h-3 bg-[#d97706] rounded-full opacity-25 animate-float hidden md:block" style="top: 65%; left: 60%; animation-delay: 5s; animation-duration: 12s;"></div>
        <div class="absolute w-2 h-2 bg-[#d97706] rounded-full opacity-30 animate-float hidden md:block" style="top: 75%; left: 40%; animation-delay: 6s; animation-duration: 8s;"></div>
        <div class="absolute w-3 h-3 bg-[#d97706] rounded-full opacity-20 animate-float hidden md:block" style="top: 85%; left: 90%; animation-delay: 7s; animation-duration: 10s;"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 lg:py-10">
        <div class="flex flex-col items-center text-center space-y-5 md:space-y-6">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/15 text-sm text-white/80">
                <span class="text-lg">🇨🇴</span>
                <span class="font-medium tracking-wide">Explora Colombia</span>
            </div>
            
            <!-- Title -->
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight">
                Descubre
                <span class="block bg-gradient-to-r from-[#059669] to-[#d97706] bg-clip-text text-transparent">Colombia</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-base md:text-lg text-white/70 max-w-2xl leading-relaxed">
                El país de la biodiversidad, cultura vibrante y aventura sin límites
            </p>
            
            <!-- Metrics - Glass Chips with Animated Counters -->
            <div class="flex flex-wrap justify-center gap-3">
                <div class="rounded-2xl bg-white/8 border border-white/10 backdrop-blur px-5 py-4 hover:bg-white/12 hover:-translate-y-[2px] transition-all duration-300 cursor-default">
                    <div class="text-2xl md:text-3xl font-bold text-[#8BEBD0] mb-1 counter-anim" data-target="{{ $stats['destinos'] ?? 0 }}">0</div>
                    <div class="text-xs text-white/70 font-medium">Destinos</div>
                </div>
                <div class="rounded-2xl bg-white/8 border border-white/10 backdrop-blur px-5 py-4 hover:bg-white/12 hover:-translate-y-[2px] transition-all duration-300 cursor-default">
                    <div class="text-2xl md:text-3xl font-bold text-[#8BEBD0] mb-1 counter-anim" data-target="{{ $stats['actividades'] ?? 0 }}">0</div>
                    <div class="text-xs text-white/70 font-medium">Actividades</div>
                </div>
                <div class="rounded-2xl bg-white/8 border border-white/10 backdrop-blur px-5 py-4 hover:bg-white/12 hover:-translate-y-[2px] transition-all duration-300 cursor-default">
                    <div class="text-2xl md:text-3xl font-bold text-[#8BEBD0] mb-1 counter-anim" data-target="{{ $stats['platos_tipicos'] ?? 0 }}">0</div>
                    <div class="text-xs text-white/70 font-medium">Gastronomía</div>
                </div>
                <div class="rounded-2xl bg-white/8 border border-white/10 backdrop-blur px-5 py-4 hover:bg-white/12 hover:-translate-y-[2px] transition-all duration-300 cursor-default">
                    <div class="text-2xl md:text-3xl font-bold text-[#8BEBD0] mb-1 counter-anim" data-target="{{ $stats['eventos'] ?? 0 }}">0</div>
                    <div class="text-xs text-white/70 font-medium">Eventos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PWA Install Button -->
<div id="pwa-install-container" class="hidden mb-6 md:mb-8">
    <button 
        id="pwa-install-btn"
        onclick="window.TurismoApp.installPWA()"
        class="w-full px-6 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-2xl font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3"
    >
        <i class="fas fa-download"></i>
        <span>Instalar app</span>
    </button>
</div>

<!-- iOS Install Instructions (shown only on iOS when not installed) -->
<div id="ios-install-container" class="hidden mb-6 md:mb-8">
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 md:p-5">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-amber-500 mt-1"></i>
            <div class="flex-1">
                <h3 class="font-semibold text-amber-900 mb-2">Instalar en iPhone/iPad</h3>
                <p class="text-sm text-amber-800 mb-3">
                    Para instalar Rutas Colombia:
                </p>
                <ol class="text-sm text-amber-800 space-y-1 list-decimal list-inside">
                    <li>Abre Compartir en Safari</li>
                    <li>Selecciona "Añadir a pantalla de inicio"</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Explorar por Categoría - Premium Circular Buttons -->
<div class="mb-8 md:mb-12">
    <h2 class="font-display text-xl sm:text-2xl md:text-3xl font-bold text-midnight-900 mb-4 md:mb-6">Explorar por Categoría</h2>

    <div class="flex gap-5 md:gap-6 lg:gap-8 overflow-x-auto pb-6 px-4 md:px-0 snap-x snap-mandatory scrollbar-hide md:justify-center md:flex-wrap">
        @foreach($explorarTipos ?? [] as $tipo)
        @php
            $nombreNormalizado = strtolower($tipo['nombre'] ?? '');
            $colorClass = 'category-forest';
            $iconoPremium = 'fas fa-star';
            
            if (str_contains($nombreNormalizado, 'gastronom') || str_contains($nombreNormalizado, 'comida') || str_contains($nombreNormalizado, 'plato')) {
                $colorClass = 'category-gastronomia';
                $iconoPremium = 'fas fa-utensils';
            } elseif (str_contains($nombreNormalizado, 'alojam') || str_contains($nombreNormalizado, 'hotel')) {
                $colorClass = 'category-alojamiento';
                $iconoPremium = 'fas fa-bed';
            } elseif (str_contains($nombreNormalizado, 'ruta') || str_contains($nombreNormalizado, 'camino')) {
                $colorClass = 'category-rutas';
                $iconoPremium = 'fas fa-route';
            } elseif (str_contains($nombreNormalizado, 'evento') || str_contains($nombreNormalizado, 'fiesta') || str_contains($nombreNormalizado, 'feria')) {
                $colorClass = 'category-eventos';
                $iconoPremium = 'fas fa-calendar-days';
            } elseif (str_contains($nombreNormalizado, 'agencia')) {
                $colorClass = 'category-agencias';
                $iconoPremium = 'fas fa-briefcase';
            } elseif (str_contains($nombreNormalizado, 'departamento') || str_contains($nombreNormalizado, 'región')) {
                $colorClass = 'category-departamentos';
                $iconoPremium = 'fas fa-map-pin';
            } elseif (str_contains($nombreNormalizado, 'actividad') || str_contains($nombreNormalizado, 'aventura') || str_contains($nombreNormalizado, 'deporte')) {
                $colorClass = 'category-actividades';
                $iconoPremium = 'fas fa-mountain';
            } elseif (str_contains($nombreNormalizado, 'categor')) {
                $colorClass = 'category-forest';
                $iconoPremium = 'fas fa-th-large';
            }
        @endphp
        <a href="{{ $tipo['url'] ?? '#' }}" class="flex-shrink-0 snap-start flex flex-col items-center gap-3 md:gap-4 group min-w-[88px] md:min-w-0 category-anim">
            <div class="category-premium-button {{ $colorClass }} w-20 h-20 md:w-24 md:h-24">
                <i class="{{ $iconoPremium }} text-white text-2xl md:text-3xl drop-shadow-sm"></i>
            </div>
            <span class="text-sm md:text-base font-medium text-gray-700 text-center whitespace-nowrap group-hover:text-midnight-900 transition-colors">{{ $tipo['nombre'] ?? '' }}</span>
        </a>
        @endforeach
    </div>
</div>

<style>
.category-premium-button {
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22), inset 0 1px 0 rgba(255, 255, 255, 0.35), inset 0 -12px 24px rgba(0, 0, 0, 0.20);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
}

.category-premium-button::before {
    content: '';
    position: absolute;
    top: 8%;
    left: 12%;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.35);
    blur: 4px;
    pointer-events: none;
}

.category-premium-button::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.25) 0%,
        transparent 50%,
        rgba(0, 0, 0, 0.15) 100%
    );
    pointer-events: none;
}

.category-premium-button:hover {
    transform: translateY(-6px) scale(1.04);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.28), inset 0 1px 0 rgba(255, 255, 255, 0.4), inset 0 -12px 24px rgba(0, 0, 0, 0.25);
    filter: brightness(1.08);
}

.category-premium-button:hover i {
    transform: scale(1.06);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.category-premium-button:active {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.3), inset 0 -8px 16px rgba(0, 0, 0, 0.18);
}

.category-premium-button:focus-visible {
    outline: none;
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.22), inset 0 1px 0 rgba(255, 255, 255, 0.35), inset 0 -12px 24px rgba(0, 0, 0, 0.20), 0 0 0 3px rgba(59, 130, 246, 0.5);
}

/* Staggered entrance animation */
@keyframes categoryEnter {
    from {
        opacity: 0;
        transform: translateY(16px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.category-anim {
    animation: categoryEnter 0.5s ease-out forwards;
    opacity: 0;
}

.category-anim:nth-child(1) { animation-delay: 0s; }
.category-anim:nth-child(2) { animation-delay: 0.06s; }
.category-anim:nth-child(3) { animation-delay: 0.12s; }
.category-anim:nth-child(4) { animation-delay: 0.18s; }
.category-anim:nth-child(5) { animation-delay: 0.24s; }
.category-anim:nth-child(6) { animation-delay: 0.3s; }
.category-anim:nth-child(7) { animation-delay: 0.36s; }
.category-anim:nth-child(8) { animation-delay: 0.42s; }

/* Color variants - Premium gradients */
.category-forest {
    background: linear-gradient(135deg, #1D4ED8 0%, #1E40AF 50%, #0D5F5F 100%);
}

.category-actividades {
    background: linear-gradient(135deg, #1D4ED8 0%, #1E40AF 50%, #0D5F5F 100%);
}

.category-gastronomia {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
}

.category-alojamiento {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
}

.category-rutas {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #c2410c 100%);
}

.category-eventos {
    background: linear-gradient(135deg, #f43f5e 0%, #e11d48 50%, #be123c 100%);
}

.category-agencias {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);
}

.category-departamentos {
    background: linear-gradient(135deg, #1D4ED8 0%, #1E40AF 50%, #0D5F5F 100%);
}

/* Premium 3D Card Utilities */
.premium-card-3d {
    border-radius: 24px;
    overflow: hidden;
    background: white;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10), 0 24px 60px rgba(15, 23, 42, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.65);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform-gpu;
}

.premium-card-3d:hover {
    transform: translateY(-8px) scale(1.015);
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15), 0 32px 80px rgba(15, 23, 42, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.7);
}

.premium-card-3d:active {
    transform: translateY(-4px) scale(1.008);
}

.premium-card-3d:focus-visible {
    outline: none;
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10), 0 24px 60px rgba(15, 23, 42, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.65), 0 0 0 3px rgba(59, 130, 246, 0.5);
}

.premium-image-hover {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.premium-card-3d:hover .premium-image-hover {
    transform: scale(1.05);
}

.premium-badge-glass {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Staggered entrance animation for cards */
@keyframes cardEnter {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.96);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.card-anim {
    animation: cardEnter 0.5s ease-out forwards;
    opacity: 0;
}

.card-anim:nth-child(1) { animation-delay: 0s; }
.card-anim:nth-child(2) { animation-delay: 0.06s; }
.card-anim:nth-child(3) { animation-delay: 0.12s; }
.card-anim:nth-child(4) { animation-delay: 0.18s; }
.card-anim:nth-child(5) { animation-delay: 0.24s; }
.card-anim:nth-child(6) { animation-delay: 0.3s; }
</style>

<!-- Destinos Destacados -->
<div class="mb-8 md:mb-12">
    <div class="flex items-center justify-between mb-4 md:mb-6">
        <h2 class="font-display text-xl sm:text-2xl md:text-3xl font-bold text-midnight-900">Destinos Destacados</h2>
        <a href="{{ route('destinos') }}" class="text-sm md:text-base font-medium text-gray-600 hover:text-midnight-900 transition-colors">
            Ver todos
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        @foreach($destinosDestacados ?? [] as $destino)
        <a href="{{ $destino['url'] ?? '#' }}" class="cinematic-card block group w-full">
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" @if($destino['imagen'] ?? null) style="background-image: url('{{ $destino['imagen'] }}'); background-size: cover; background-position: center;" @else style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);" @endif>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute top-3 left-3 md:top-4 md:left-4 glass-badge text-xs">
                    {{ $destino['categoria'] ?? '' }}
                </div>
                <div class="absolute bottom-3 right-3 md:bottom-4 md:right-4 glass-badge bg-yellow-500/30 text-xs">
                    <span class="text-yellow-400">★</span> {{ $destino['calificacion'] ?? 0 }}
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
                    <h3 class="font-display text-base md:text-lg lg:text-xl font-bold mb-1">{{ $destino['nombre'] ?? '' }}</h3>
                    <p class="text-xs md:text-sm opacity-90 line-clamp-2">Joyas del Caribe con murallas coloniales y playas paradisíacas.</p>
                    <div class="flex items-center gap-2 text-xs md:text-sm mt-2 opacity-90">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $destino['ubicacion'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

<!-- Experiencias Patrocinadas Premium -->
<div class="mb-8 md:mb-12 lg:mb-16">
    <!-- Hero Patrocinado Fullwidth - Premium 3D Composition -->
    <div class="relative h-[280px] sm:h-[320px] md:h-[380px] lg:h-[450px] xl:h-[520px] overflow-hidden rounded-[32px] mb-6 md:mb-8 lg:mb-12 group w-full" style="background: linear-gradient(135deg, #0c4a6e 0%, #075985 25%, #0369a1 50%, #0284c7 75%, #0ea5e9 100%); box-shadow: 0 25px 60px rgba(0,0,0,0.25), 0 50px 100px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.15), inset 0 -1px 0 rgba(0,0,0,0.1);">
        <!-- Ambient Glow Effects -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-600/15 rounded-full blur-3xl"></div>
        
        <!-- Glassmorphism Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-black/10 backdrop-blur-[2px]"></div>
        
        <!-- Decorative Pattern -->
        <div class="absolute inset-0 opacity-[0.03]">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hero-pattern" width="60" height="60" patternUnits="userSpaceOnUse">
                        <circle cx="30" cy="30" r="1" fill="white"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-pattern)"/>
            </svg>
        </div>
        
        <!-- Content Grid -->
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center h-full">
                <!-- Left Column: Text Content -->
                <div class="space-y-4 md:space-y-6">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs md:text-sm font-medium shadow-lg" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                        <span class="text-sm">✨</span>
                        <span>Patrocinado</span>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight" style="text-shadow: 2px 2px 20px rgba(0,0,0,0.5);">
                        Escápate al Caribe Colombiano
                    </h2>
                    
                    <!-- Subtitle -->
                    <p class="text-sm md:text-base lg:text-lg xl:text-xl text-white/90 max-w-xl leading-relaxed" style="text-shadow: 1px 1px 8px rgba(0,0,0,0.4);">
                        Descubre hoteles eco-friendly y experiencias exclusivas en la costa caribeña
                    </p>
                    
                    <!-- Buttons -->
                    <div class="flex flex-wrap gap-3 md:gap-4">
                        <button class="px-6 py-3 md:px-8 md:py-4 lg:px-10 lg:py-5 bg-white text-midnight-900 rounded-full font-semibold hover:bg-white/95 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1 text-sm md:text-base lg:text-lg" style="box-shadow: 0 8px 25px rgba(0,0,0,0.3);">
                            Reservar experiencia
                        </button>
                        <button class="px-6 py-3 md:px-8 md:py-4 lg:px-10 lg:py-5 bg-white/15 backdrop-blur-md text-white rounded-full font-semibold hover:bg-white/25 transition-all duration-300 border border-white/30 shadow-lg hover:shadow-xl hover:-translate-y-1 text-sm md:text-base lg:text-lg" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            Explorar destino
                        </button>
                    </div>
                </div>
                
                <!-- Right Column: Decorative Visual -->
                <div class="hidden lg:flex items-center justify-center relative">
                    <!-- Floating Card 1 -->
                    <div class="absolute top-8 right-8 w-32 h-32 md:w-40 md:h-40 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-2xl" style="box-shadow: 0 20px 40px rgba(0,0,0,0.3); transform: rotate(6deg);">
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl mb-1">🏖️</div>
                            <div class="text-white/80 text-xs font-medium">Playas</div>
                        </div>
                    </div>
                    
                    <!-- Floating Card 2 -->
                    <div class="absolute bottom-12 left-12 w-28 h-28 md:w-36 md:h-36 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-2xl" style="box-shadow: 0 20px 40px rgba(0,0,0,0.3); transform: rotate(-4deg);">
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl mb-1">🌴</div>
                            <div class="text-white/80 text-xs font-medium">Naturaleza</div>
                        </div>
                    </div>
                    
                    <!-- Central Decorative Element -->
                    <div class="relative w-48 h-48 md:w-64 md:h-64 rounded-full bg-gradient-to-br from-white/20 to-transparent backdrop-blur-sm border border-white/30 flex items-center justify-center" style="box-shadow: 0 25px 50px rgba(0,0,0,0.25);">
                        <div class="text-center">
                            <div class="text-5xl md:text-6xl mb-2">🌊</div>
                            <div class="text-white font-semibold text-sm md:text-base">Caribe</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Shine -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
    </div>

    <!-- Hoteles Destacados -->
    <div class="mb-6 md:mb-8 lg:mb-12">
        <div class="flex items-center justify-between mb-4 md:mb-6">
            <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900">Hoteles Destacados</h2>
            <a href="{{ route('alojamiento') }}" class="text-sm md:text-base font-medium text-gray-600 hover:text-midnight-900 transition-colors">
                Ver todos
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 lg:gap-6">
            @foreach($hotelesDestacados ?? [] as $hotel)
            <a href="/alojamiento" class="cinematic-card block group w-full card-anim">
                <div class="relative h-40 sm:h-48 md:h-56 lg:h-64 overflow-hidden rounded-t-2xl md:rounded-t-3xl w-full premium-image-hover" @if($hotel['imagen'] ?? null) style="background-image: url('{{ $hotel['imagen'] }}'); background-size: cover; background-position: center;" @else style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);" @endif>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute top-2 left-2 md:top-3 md:left-4 glass-badge bg-[#1D4ED8]/30 px-2 py-0.5 md:px-3 md:py-1 text-[10px] md:text-xs">
                        🌿 {{ $hotel['categoria'] ?? '' }}
                    </div>
                    <div class="absolute top-2 right-2 md:top-3 md:right-4 glass-badge bg-white/90 px-2 py-0.5 md:px-3 md:py-1 text-[10px] md:text-xs">
                        <span class="text-yellow-400">★</span> {{ $hotel['calificacion'] ?? 0 }}
                    </div>
                </div>
                <div class="p-3 md:p-4 lg:p-6 premium-card-3d rounded-b-2xl md:rounded-b-3xl">
                    <div class="flex items-center gap-2 text-[10px] md:text-xs lg:text-sm text-gray-500 mb-1 md:mb-2">
                        <i class="fas fa-map-marker-alt text-xs md:text-sm"></i>
                        <span class="truncate">{{ $hotel['ubicacion'] ?? '' }}</span>
                    </div>
                    <h3 class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold text-midnight-900 mb-1 md:mb-2">{{ $hotel['nombre'] ?? '' }}</h3>
                    <p class="text-gray-600 text-[10px] md:text-xs lg:text-sm mb-2 md:mb-3 lg:mb-4 line-clamp-2">Luxury eco-lodge nestled in the heart of Tayrona National Park</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-base md:text-lg lg:text-xl xl:text-2xl font-bold text-midnight-900">${{ $hotel['precio'] ?? 0 }}</span>
                            <span class="text-gray-500 text-[10px] md:text-xs lg:text-sm">/noche</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Experiencias Gastronómicas -->
    <div class="mb-6 md:mb-8 lg:mb-12" data-preference-section="gastronomy">
        <div class="flex items-center justify-between mb-4 md:mb-6">
            <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900">Experiencias Gastronómicas</h2>
            <a href="{{ route('gastronomia') }}" class="text-sm md:text-base font-medium text-gray-600 hover:text-midnight-900 transition-colors">
                Ver todos
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-3 lg:gap-4">
            @foreach($gastronomiaDestacada ?? [] as $gastro)
            <a href="/gastronomia" class="cinematic-card block group w-full card-anim">
                <div class="relative h-32 sm:h-36 md:h-40 lg:h-48 overflow-hidden rounded-2xl md:rounded-3xl w-full premium-card-3d premium-image-hover" @if($gastro['imagen'] ?? null) style="background-image: url('{{ $gastro['imagen'] }}'); background-size: cover; background-position: center;" @else style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%);" @endif>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-2 left-2 md:bottom-3 md:left-4 text-white">
                        <div class="glass-badge bg-white/20 backdrop-blur-md px-1.5 py-0.5 md:px-2 md:py-1 rounded-full text-[9px] md:text-xs mb-1 md:mb-2 inline-block">
                            🍽️ {{ $gastro['categoria'] ?? '' }}
                        </div>
                        <h3 class="font-bold text-xs md:text-sm lg:text-base">{{ $gastro['nombre'] ?? '' }}</h3>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Eventos Imperdibles -->
    <div class="mb-6 md:mb-8 lg:mb-12">
        <div class="flex items-center justify-between mb-4 md:mb-6">
            <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900">Eventos Imperdibles</h2>
            <a href="{{ route('fiestas-ferias.index') }}" class="text-sm md:text-base font-medium text-gray-600 hover:text-midnight-900 transition-colors">
                Ver todos
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 lg:gap-6">
            @foreach($eventosDestacados ?? [] as $evento)
            <a href="/eventos" class="cinematic-card block group w-full card-anim">
                <div class="relative h-40 sm:h-48 md:h-56 lg:h-64 overflow-hidden rounded-t-2xl md:rounded-t-3xl w-full premium-image-hover" @if($evento['imagen'] ?? null) style="background-image: url('{{ $evento['imagen'] }}'); background-size: cover; background-position: center;" @else style="background: linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%);" @endif>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute top-2 left-2 md:top-3 md:left-4 glass-badge bg-pink-500/30 px-2 py-0.5 md:px-3 md:py-1 text-[10px] md:text-xs">
                        🎉 Evento
                    </div>
                    <div class="absolute top-2 right-2 md:top-3 md:right-4 glass-badge bg-white/90 px-2 py-0.5 md:px-3 md:py-1 text-[10px] md:text-xs">
                        <span class="text-[10px] md:text-xs font-semibold">{{ $evento['fecha'] ?? '' }}</span>
                    </div>
                </div>
                <div class="p-3 md:p-4 lg:p-6 premium-card-3d rounded-b-2xl md:rounded-b-3xl">
                    <h3 class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold text-midnight-900 mb-1 md:mb-2">{{ $evento['nombre'] ?? '' }}</h3>
                    <p class="text-gray-600 text-[10px] md:text-xs lg:text-sm mb-2 md:mb-3 lg:mb-4 line-clamp-2">Evento destacado en {{ $evento['ubicacion'] ?? '' }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-[10px] md:text-xs lg:text-sm text-gray-500">
                            <i class="fas fa-calendar-alt text-xs md:text-sm"></i>
                            <span>{{ $evento['fecha'] ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Inspírate para tu próximo viaje -->
    <div class="mb-6 md:mb-8 lg:mb-12">
        <div class="flex items-center justify-between mb-4 md:mb-6">
            <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900">Inspírate para tu próximo viaje</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-3 lg:gap-6">
            <a href="{{ route('puntos-interes.playas') }}" class="cinematic-card block group w-full card-anim" data-preference-section="nature">
                <div class="relative h-32 sm:h-36 md:h-40 lg:h-48 overflow-hidden rounded-2xl md:rounded-3xl w-full premium-card-3d premium-image-hover">
                    <img src="{{ $inspiracionImages['playas'] }}" alt="Playas del Caribe" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute top-3 right-3">
                        <div class="bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full text-white text-xs font-medium">Descubrir</div>
                    </div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <i class="fas fa-umbrella-beach text-lg md:text-xl lg:text-2xl mb-1 md:mb-2"></i>
                        <h3 class="font-bold text-xs md:text-sm lg:text-base">Playas del Caribe</h3>
                        <p class="text-[10px] md:text-xs lg:text-sm opacity-90">Mar, arena y paisajes costeros</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('puntos-interes.museos') }}" class="cinematic-card block group w-full card-anim" data-preference-section="culture">
                <div class="relative h-32 sm:h-36 md:h-40 lg:h-48 overflow-hidden rounded-2xl md:rounded-3xl w-full premium-card-3d premium-image-hover">
                    <img src="{{ $inspiracionImages['museos'] }}" alt="Museos & Cultura" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute top-3 right-3">
                        <div class="bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full text-white text-xs font-medium">Descubrir</div>
                    </div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <i class="fas fa-landmark text-lg md:text-xl lg:text-2xl mb-1 md:mb-2"></i>
                        <h3 class="font-bold text-xs md:text-sm lg:text-base">Museos & Cultura</h3>
                        <p class="text-[10px] md:text-xs lg:text-sm opacity-90">Historia, arte y patrimonio colombiano</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('puntos-interes.deportes-aventura') }}" class="cinematic-card block group w-full card-anim" data-preference-section="nature">
                <div class="relative h-32 sm:h-36 md:h-40 lg:h-48 overflow-hidden rounded-2xl md:rounded-3xl w-full premium-card-3d premium-image-hover">
                    <img src="{{ $inspiracionImages['aventura'] }}" alt="Aventura & Naturaleza" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute top-3 right-3">
                        <div class="bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full text-white text-xs font-medium">Descubrir</div>
                    </div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <i class="fas fa-hiking text-lg md:text-xl lg:text-2xl mb-1 md:mb-2"></i>
                        <h3 class="font-bold text-xs md:text-sm lg:text-base">Aventura & Naturaleza</h3>
                        <p class="text-[10px] md:text-xs lg:text-sm opacity-90">Rutas, montañas y experiencias al aire libre</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('gastronomia') }}" class="cinematic-card block group w-full card-anim">
                <div class="relative h-32 sm:h-36 md:h-40 lg:h-48 overflow-hidden rounded-2xl md:rounded-3xl w-full premium-card-3d premium-image-hover">
                    <img src="{{ $inspiracionImages['gastronomia'] }}" alt="Gastronomía Local" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute top-3 right-3">
                        <div class="bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full text-white text-xs font-medium">Descubrir</div>
                    </div>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <i class="fas fa-utensils text-lg md:text-xl lg:text-2xl mb-1 md:mb-2"></i>
                        <h3 class="font-bold text-xs md:text-sm lg:text-base">Gastronomía Local</h3>
                        <p class="text-[10px] md:text-xs lg:text-sm opacity-90">Sabores tradicionales de cada región</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Síguenos y Descubre Más - Premium 3D -->
    <div class="mt-8 md:mt-12 lg:mt-16 bg-gradient-to-br from-[#f8f5f0] via-[#f0ebe3] to-[#e8e3db] rounded-[28px] md:rounded-[36px] p-5 md:p-8 lg:p-10" style="box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 40px 100px rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.8);">
        <!-- Header -->
        <div class="text-center mb-6 md:mb-8 lg:mb-10">
            <h2 class="font-display text-2xl sm:text-3xl md:text-4xl font-bold text-[#0f2d1a] mb-3">Síguenos y descubre más de Colombia</h2>
            <p class="text-gray-600 text-sm md:text-base lg:text-lg max-w-full md:max-w-2xl mx-auto leading-relaxed">Encuentra rutas, cultura, gastronomía, paisajes y experiencias en nuestros canales oficiales.</p>
        </div>

        <!-- Cards de Plataformas - Premium 3D -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 lg:gap-6 mb-6 md:mb-8">
            <!-- Facebook -->
            <div class="relative bg-white/90 backdrop-blur-sm rounded-[24px] md:rounded-[32px] border border-white/40 p-4 md:p-5 lg:p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
                <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-5">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-gradient-to-br from-[#1877F2]/20 to-[#1877F2]/5 flex items-center justify-center shadow-sm" style="box-shadow: 0 4px 12px rgba(24,119,242,0.15);">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm md:text-base">Facebook</h3>
                        <p class="text-[11px] md:text-xs text-gray-500 font-medium">GUIA DE RUTAS POR COLOMBIA</p>
                    </div>
                </div>
                <p class="text-gray-600 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2 leading-relaxed">Toda la información turística de Colombia.</p>
                <a href="https://www.facebook.com/rutascolombia" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-3 px-4 md:px-5 bg-[#1877F2] text-white rounded-2xl md:rounded-3xl text-sm md:text-base font-semibold hover:bg-[#166fe5] transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5" style="box-shadow: 0 6px 20px rgba(24,119,242,0.3);">
                    Ver Facebook
                </a>
            </div>

            <!-- YouTube -->
            <div class="relative bg-white/90 backdrop-blur-sm rounded-[24px] md:rounded-[32px] border border-white/40 p-4 md:p-5 lg:p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
                <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-5">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-gradient-to-br from-[#FF0000]/20 to-[#FF0000]/5 flex items-center justify-center shadow-sm" style="box-shadow: 0 4px 12px rgba(255,0,0,0.15);">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-[#FF0000]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm md:text-base">YouTube</h3>
                        <p class="text-[11px] md:text-xs text-gray-500 font-medium">Guía de Rutas por Colombia</p>
                    </div>
                </div>
                <p class="text-gray-600 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2 leading-relaxed">La mejor Guía de Turismo en Colombia. Cultura, gastronomía, sitios turísticos.</p>
                <a href="https://www.youtube.com/@guiaderutasporcolombia9334" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-3 px-4 md:px-5 bg-[#FF0000] text-white rounded-2xl md:rounded-3xl text-sm md:text-base font-semibold hover:bg-[#e60000] transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5" style="box-shadow: 0 6px 20px rgba(255,0,0,0.3);">
                    Ver YouTube
                </a>
            </div>

            <!-- Instagram -->
            <div class="relative bg-white/90 backdrop-blur-sm rounded-[24px] md:rounded-[32px] border border-white/40 p-4 md:p-5 lg:p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
                <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-5">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-gradient-to-br from-[#833AB4]/20 via-[#FD1D1D]/15 to-[#F77737]/10 flex items-center justify-center shadow-sm" style="box-shadow: 0 4px 12px rgba(225,48,108,0.15);">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-[#E1306C]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm md:text-base">Instagram</h3>
                        <p class="text-[11px] md:text-xs text-gray-500 font-medium">@guiaderutasporcolombia</p>
                    </div>
                </div>
                <p class="text-gray-600 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2 leading-relaxed">Aquí encontrarás la forma de vivir nuevas experiencias por Colombia.</p>
                <a href="https://www.instagram.com/guiaderutasporcolombia/" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-3 px-4 md:px-5 bg-gradient-to-r from-[#833AB4] via-[#FD1D1D] to-[#F77737] text-white rounded-2xl md:rounded-3xl text-sm md:text-base font-semibold hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5" style="box-shadow: 0 6px 20px rgba(225,48,108,0.3);">
                    Ver Instagram
                </a>
            </div>

            <!-- X / Twitter -->
            <div class="relative bg-white/90 backdrop-blur-sm rounded-[24px] md:rounded-[32px] border border-white/40 p-4 md:p-5 lg:p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
                <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-5">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-gradient-to-br from-black/15 to-black/5 flex items-center justify-center shadow-sm" style="box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm md:text-base">X</h3>
                        <p class="text-[11px] md:text-xs text-gray-500 font-medium">@rutascolombia</p>
                    </div>
                </div>
                <p class="text-gray-600 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2 leading-relaxed">Anímate a viajar por Colombia y a conocer sus maravillas.</p>
                <a href="https://x.com/rutascolombia" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-3 px-4 md:px-5 bg-black text-white rounded-2xl md:rounded-3xl text-sm md:text-base font-semibold hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5" style="box-shadow: 0 6px 20px rgba(0,0,0,0.3);">
                    Ver X
                </a>
            </div>
        </div>
    </div>

    <!-- Padding bottom para navegación móvil -->
    <div class="h-20 md:h-0"></div>

</div>
@endsection

<style>
/* Floating animation for gold particles */
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-30px);
    }
}

.animate-float {
    animation: float ease-in-out infinite;
}

/* Carousel Styles */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.carousel-track > * {
    flex-shrink: 0;
    scroll-snap-align: start;
}
</style>

<script>
// Animated counters for metrics
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter-anim');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 1500; // 1.5 seconds
        const startTime = performance.now();
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function for smooth animation
            const easeOutQuart = 1 - Math.pow(1 - progress, 4);
            const current = Math.floor(easeOutQuart * target);
            
            counter.textContent = current;
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        }
        
        requestAnimationFrame(updateCounter);
    });

    // Initialize all carousels
    document.querySelectorAll('.carousel-track').forEach(carousel => {
        const container = carousel.closest('[id$="-container"]');
        const prevBtn = container.querySelector('.carousel-prev-btn');
        const nextBtn = container.querySelector('.carousel-next-btn');
        const progressBar = container.querySelector('.carousel-progress');
        
        if (!prevBtn || !nextBtn) return;
        
        const itemsPerViewMobile = parseFloat(carousel.dataset.itemsPerViewMobile) || 1.5;
        const itemsPerViewTablet = parseFloat(carousel.dataset.itemsPerViewTablet) || 2;
        const itemsPerViewDesktop = parseFloat(carousel.dataset.itemsPerViewDesktop) || 4;
        
        function getItemsPerView() {
            if (window.innerWidth >= 1024) return itemsPerViewDesktop;
            if (window.innerWidth >= 768) return itemsPerViewTablet;
            return itemsPerViewMobile;
        }
        
        function updateButtons() {
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
            prevBtn.disabled = carousel.scrollLeft <= 0;
            nextBtn.disabled = carousel.scrollLeft >= maxScroll - 1;
            
            if (progressBar) {
                const progress = (carousel.scrollLeft / maxScroll) * 100;
                progressBar.style.width = progress + '%';
            }
        }
        
        function scrollByItems(direction) {
            const itemWidth = carousel.firstElementChild.offsetWidth;
            const itemsPerView = getItemsPerView();
            const scrollAmount = itemWidth * Math.floor(itemsPerView);
            
            carousel.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
        
        prevBtn.addEventListener('click', () => scrollByItems(-1));
        nextBtn.addEventListener('click', () => scrollByItems(1));
        
        carousel.addEventListener('scroll', updateButtons);
        window.addEventListener('resize', updateButtons);
        
        setTimeout(updateButtons, 100);
    });

    // PWA Install Button Logic
    const pwaInstallContainer = document.getElementById('pwa-install-container');
    const iosInstallContainer = document.getElementById('ios-install-container');

    // Initialize PWA UI when TurismoApp is ready
    const initPWAUI = () => {
        const turismoApp = window.TurismoApp;
        
        if (!turismoApp) {
            console.warn('⚠️ TurismoApp not available');
            return;
        }

        // Hide install containers if already in standalone mode
        if (turismoApp.isStandalone) {
            if (pwaInstallContainer) pwaInstallContainer.classList.add('hidden');
            if (iosInstallContainer) iosInstallContainer.classList.add('hidden');
            return;
        }

        // Show iOS instructions on iOS when not in standalone mode
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        if (isIOS && iosInstallContainer) {
            iosInstallContainer.classList.remove('hidden');
        }
    };

    // Listen for PWA ready event
    window.addEventListener('pwa-ready', initPWAUI);

    // Also initialize immediately if TurismoApp is already available
    if (window.TurismoApp) {
        initPWAUI();
    }

    // Show install button when available (Android/Chrome)
    window.addEventListener('pwa-install-available', () => {
        const turismoApp = window.TurismoApp;
        if (pwaInstallContainer && turismoApp && !turismoApp.isStandalone) {
            pwaInstallContainer.classList.remove('hidden');
        }
    });

    // Hide install button when installed
    window.addEventListener('pwa-installed', () => {
        if (pwaInstallContainer) {
            pwaInstallContainer.classList.add('hidden');
        }
    });
});
</script>
