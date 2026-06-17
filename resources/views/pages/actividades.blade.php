@extends('layouts.premium')

@section('title', 'Actividades')

@section('content')
<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🧗 Turismo y Aventura
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Actividades y Aventuras
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Vive experiencias únicas en Colombia
        </p>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">50+</div>
        <div class="text-sm text-gray-600 font-medium">Actividades</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">32</div>
        <div class="text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">100%</div>
        <div class="text-sm text-gray-600 font-medium">Seguro</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">24/7</div>
        <div class="text-sm text-gray-600 font-medium">Disponible</div>
    </div>
</div>

<!-- Actividades Destacadas -->
<h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6 text-center">Actividades Destacadas</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
    
    <!-- Actividad 1 -->
    <div class="cinematic-card group cursor-pointer">
        <div class="relative h-56 overflow-hidden rounded-t-[32px]" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%);">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4 glass-badge bg-[#1D4ED8]/30">
                🪂 Extremo
            </div>
            <div class="absolute bottom-4 left-4 text-white">
                <div class="flex gap-4 text-sm font-medium">
                    <span><i class="fas fa-star mr-1"></i> 5.0</span>
                    <span><i class="fas fa-bolt mr-1"></i> Adrenalina</span>
                </div>
            </div>
        </div>
        <div class="p-5">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">Paracaidismo</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">Salta desde 4000 metros de altura y admira paisajes increíbles.</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                <span>Santa Fe de Antioquia</span>
            </div>
        </div>
    </div>

    <!-- Actividad 2 -->
    <div class="cinematic-card group cursor-pointer">
        <div class="relative h-56 overflow-hidden rounded-t-[32px]" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4 glass-badge bg-[#1D4ED8]/30">
                🚣 Aventura
            </div>
            <div class="absolute bottom-4 left-4 text-white">
                <div class="flex gap-4 text-sm font-medium">
                    <span><i class="fas fa-star mr-1"></i> 5.0</span>
                    <span><i class="fas fa-water mr-1"></i> Río</span>
                </div>
            </div>
        </div>
        <div class="p-5">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">Rafting</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">Navega rápidos clase III y IV en el río Samaná.</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                <span>San Gil, Santander</span>
            </div>
        </div>
    </div>

    <!-- Actividad 3 -->
    <div class="cinematic-card group cursor-pointer">
        <div class="relative h-56 overflow-hidden rounded-t-[32px]" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%);">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4 glass-badge bg-[#1D4ED8]/30">
                🤿 Mar
            </div>
            <div class="absolute bottom-4 left-4 text-white">
                <div class="flex gap-4 text-sm font-medium">
                    <span><i class="fas fa-star mr-1"></i> 5.0</span>
                    <span><i class="fas fa-fish mr-1"></i> Arrecifes</span>
                </div>
            </div>
        </div>
        <div class="p-5">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">Buceo</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">Explora arrecifes de coral y peces tropicales.</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                <span>Cartagena, Islas del Rosario</span>
            </div>
        </div>
    </div>

    <!-- Actividad 4 -->
    <div class="cinematic-card group cursor-pointer">
        <div class="relative h-56 overflow-hidden rounded-t-[32px]" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4 glass-badge bg-[#1D4ED8]/30">
                🥾 Senderismo
            </div>
            <div class="absolute bottom-4 left-4 text-white">
                <div class="flex gap-4 text-sm font-medium">
                    <span><i class="fas fa-star mr-1"></i> 5.0</span>
                    <span><i class="fas fa-mountain mr-1"></i> Naturaleza</span>
                </div>
            </div>
        </div>
        <div class="p-5">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">Trekking en Tayrona</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">Caminata por senderos ancestrales hasta playas vírgenes.</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                <span>Santa Marta, Parque Tayrona</span>
            </div>
        </div>
    </div>

    <!-- Actividad 5 -->
    <div class="cinematic-card group cursor-pointer">
        <div class="relative h-56 overflow-hidden rounded-t-[32px]" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #c2410c 100%);">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4 glass-badge bg-[#1D4ED8]/30">
                🧗 Desafío
            </div>
            <div class="absolute bottom-4 left-4 text-white">
                <div class="flex gap-4 text-sm font-medium">
                    <span><i class="fas fa-star mr-1"></i> 5.0</span>
                    <span><i class="fas fa-mountain mr-1"></i> Rocas</span>
                </div>
            </div>
        </div>
        <div class="p-5">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">Escalada en Rocas</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">Reta tus límites escalando las paredes de roca.</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                <span>Suesca, Cundinamarca</span>
            </div>
        </div>
    </div>

    <!-- Actividad 6 -->
    <div class="cinematic-card group cursor-pointer">
        <div class="relative h-56 overflow-hidden rounded-t-[32px]" style="background: linear-gradient(135deg, #84cc16 0%, #65a30d 50%, #4d7c0f 100%);">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4 glass-badge bg-[#1D4ED8]/30">
                🌲 Bosque
            </div>
            <div class="absolute bottom-4 left-4 text-white">
                <div class="flex gap-4 text-sm font-medium">
                    <span><i class="fas fa-star mr-1"></i> 5.0</span>
                    <span><i class="fas fa-tree mr-1"></i> Aventura</span>
                </div>
            </div>
        </div>
        <div class="p-5">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">Canopy Tour</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">Vuela sobre el dosel del bosque con vistas espectaculares.</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                <span>Eje Cafetero</span>
            </div>
        </div>
    </div>

</div>

<!-- Explorar Más -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Aventuras</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Descubre otras categorías de turismo en Colombia</p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/playas" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            🏖️ Playas
        </a>
        <a href="/islas" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🏝️ Islas
        </a>
        <a href="/reservas-naturales" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🌲 Reservas Naturales
        </a>
    </div>
</div>

</div>
@endsection
