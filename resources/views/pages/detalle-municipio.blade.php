@extends('layouts.premium')

@section('title', $item->nombre ?? 'Detalle')

@php
function getExperienceGradient($category) {
    $gradients = [
        'Cultura' => 'linear-gradient(135deg, #92400e 0%, #78350f 50%, #451a03 100%)',
        'Naturaleza' => 'linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%)',
        'Gastronomía' => 'linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%)',
        'Actividad' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%)',
        'General' => 'linear-gradient(135deg, #6b7280 0%, #4b5563 50%, #374151 100%)',
    ];
    return $gradients[$category] ?? $gradients['General'];
}
@endphp

@section('content')
@if(!$item)
<!-- Error State -->
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12 md:py-20">
    <div class="bg-white/80 backdrop-blur-sm p-8 md:p-12 lg:p-16 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
        <div class="w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 md:mb-8">
            <i class="fas fa-exclamation-triangle text-white text-3xl md:text-4xl"></i>
        </div>
        <h1 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 md:mb-6">
            {{ $error ?? 'Municipio no encontrado' }}
        </h1>
        <p class="text-gray-600 text-sm md:text-base lg:text-lg mb-6 md:mb-8 max-w-2xl mx-auto">
            Lo sentimos, no pudimos encontrar el municipio que buscas. Es posible que haya sido eliminado o que el enlace sea incorrecto.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
            <a href="{{ route('municipios.index') }}" class="px-6 py-3 md:px-8 md:py-4 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs md:text-sm hover:shadow-lg transition-all">
                <i class="fas fa-city mr-2"></i> Ver todos los municipios
            </a>
            <a href="{{ route('departamentos.index') }}" class="px-6 py-3 md:px-8 md:py-4 bg-white/50 backdrop-blur-md text-gray-700 rounded-full font-semibold text-xs md:text-sm hover:bg-white/70 transition-all border border-gray-200">
                <i class="fas fa-map mr-2"></i> Explorar departamentos
            </a>
        </div>
    </div>
</div>
@else
<!-- Main Container -->
<div class="detail-destination-page w-full min-w-0 overflow-x-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<!-- Hero Section -->
<div class="relative h-[40vh] sm:h-[50vh] md:h-[60vh] lg:h-[75vh] min-h-[300px] md:min-h-[400px] lg:min-h-[600px] overflow-hidden rounded-[24px] sm:rounded-[28px] md:rounded-[32px] mb-6 md:mb-8 w-full">
    @if($item->imagen)
    <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="absolute inset-0 w-full h-full object-cover">
    @else
    <div class="absolute inset-0 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] flex items-center justify-center">
        <i class="fas fa-city text-white text-4xl md:text-5xl lg:text-8xl opacity-30"></i>
    </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="bg-white/90 backdrop-blur-sm inline-block mb-2 md:mb-6 px-2 py-1 md:px-4 md:py-2 rounded-full text-[10px] md:text-sm font-semibold text-gray-800 shadow-md z-10">
            🏙️ Municipio
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-7xl font-bold mb-2 md:mb-4 leading-tight" style="text-shadow: 2px 2px 12px rgba(0,0,0,0.8);">
            {{ $item->nombre }}
        </h1>
        <p id="descripcion-hero" class="text-xs md:text-sm lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-3xl mb-3 md:mb-6 line-clamp-4 md:line-clamp-none" style="text-shadow: 1px 1px 6px rgba(0,0,0,0.6);">
            {{ $item->descripcion ?? 'Descubre los tesoros ocultos de este increíble municipio' }}
        </p>
        <button id="btn-leer-mas" onclick="toggleDescripcion()" class="md:hidden text-xs text-white/80 underline mb-3 md:mb-6">
            Leer más
        </button>
        <div class="flex flex-wrap gap-2 md:gap-4 mb-3 md:mb-6">
            @if($item->departamento_nombre)
            <div class="bg-white/20 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-full text-[10px] md:text-sm text-white border border-white/30">
                <i class="fas fa-map mr-1 md:mr-2 text-[10px] md:text-sm"></i> {{ $item->departamento_nombre }}
            </div>
            @endif
            <div class="bg-white/20 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-full text-[10px] md:text-sm text-white border border-white/30">
                <i class="fas fa-flag mr-1 md:mr-2 text-[10px] md:text-sm"></i> Colombia
            </div>
        </div>
        <div class="flex flex-wrap gap-2 md:gap-4">
            <button onclick="scrollToSection('lugares-destacados')" class="w-full sm:w-auto px-4 py-3 md:px-8 md:py-4 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs md:text-lg hover:shadow-2xl transition-all hover:scale-105 cursor-pointer">
                🗺️ Explorar Lugares
            </button>
            <button onclick="scrollToSection('informacion-municipio')" class="w-full sm:w-auto px-4 py-3 md:px-8 md:py-4 bg-white/20 backdrop-blur-md text-white rounded-full font-semibold text-xs md:text-lg hover:bg-white/30 transition-all border border-white/30 cursor-pointer">
                📍 Ver Información
            </button>
        </div>
    </div>
</div>

<!-- Premium Stats -->
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[32px] shadow-lg">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">25°C</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Temperatura</div>
        </div>
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">4.7</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Calificación</div>
        </div>
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">50+</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Atracciones</div>
        </div>
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">12</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Categorías</div>
        </div>
    </div>
</div>

<!-- Municipality Info Section -->
<div id="informacion-municipio" class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[32px] shadow-lg">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Información del Municipio</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
        @if($item->departamento_nombre)
        <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 bg-white/50 rounded-2xl">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-map text-white text-lg md:text-xl"></i>
            </div>
            <div>
                <div class="text-[10px] md:text-xs text-gray-500 font-medium">Departamento</div>
                <div class="font-bold text-midnight-900 text-sm md:text-base">{{ $item->departamento_nombre }}</div>
            </div>
        </div>
        @endif
        @if($item->region)
        <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 bg-white/50 rounded-2xl">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-compass text-white text-lg md:text-xl"></i>
            </div>
            <div>
                <div class="text-[10px] md:text-xs text-gray-500 font-medium">Región</div>
                <div class="font-bold text-midnight-900 text-sm md:text-base">{{ $item->region }}</div>
            </div>
        </div>
        @endif
        <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 bg-white/50 rounded-2xl">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-thermometer-half text-white text-lg md:text-xl"></i>
            </div>
            <div>
                <div class="text-[10px] md:text-xs text-gray-500 font-medium">Clima</div>
                <div class="font-bold text-midnight-900 text-sm md:text-base">Tropical</div>
            </div>
        </div>
    </div>
</div>

<!-- Description Section -->
@if($item->descripcion)
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[32px] shadow-lg">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Sobre {{ $item->nombre }}</h2>
    <div class="prose prose-sm md:prose-base max-w-none text-gray-700 leading-relaxed">
        {!! nl2br(e($item->descripcion)) !!}
    </div>
</div>
@else
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[32px] shadow-lg">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Sobre {{ $item->nombre }}</h2>
    <p class="text-gray-600 text-sm md:text-base">Aún no hay una descripción disponible para este municipio.</p>
</div>
@endif

<!-- Visual Gallery -->
<div class="mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Galería Visual</h2>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 md:gap-4">
        @if($item->departamento_slug && $item->slug)
        @php
            $galleryImages = [
                'paisajes' => [
                    'gradient' => 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%)',
                    'title' => 'Paisajes',
                    'description' => 'Vistas panorámicas y paisajes naturales'
                ],
                'gastronomia' => [
                    'gradient' => 'linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%)',
                    'title' => 'Gastronomía',
                    'description' => 'Sabores locales y cocina tradicional'
                ],
                'naturaleza' => [
                    'gradient' => 'linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%)',
                    'title' => 'Naturaleza',
                    'description' => 'Reservas y ecosistemas naturales'
                ],
                'cultura' => [
                    'gradient' => 'linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%)',
                    'title' => 'Cultura',
                    'description' => 'Historia, tradiciones y patrimonio'
                ],
                'eventos' => [
                    'gradient' => 'linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%)',
                    'title' => 'Eventos',
                    'description' => 'Festivales y celebraciones'
                ]
            ];
        @endphp
        <a href="{{ route('municipios.categoria.slug', [$item->departamento_slug, $item->slug, 'paisajes']) }}" class="lg:col-span-7 relative h-48 sm:h-56 md:h-64 lg:h-96 overflow-hidden rounded-[20px] md:rounded-[32px] group cursor-pointer w-full" aria-label="Explorar paisajes de {{ $item->nombre }}" style="background: {{ $galleryImages['paisajes']['gradient'] }};">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:bg-gradient-to-t group-hover:from-black/70 group-hover:to-transparent transition-all"></div>
            <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                <div class="font-display text-base md:text-lg lg:text-xl font-bold">{{ $galleryImages['paisajes']['title'] }}</div>
                <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Explorar <i class="fas fa-arrow-right ml-1"></i></div>
            </div>
        </a>
        <div class="lg:col-span-5 grid grid-cols-2 gap-3 md:gap-4">
            @foreach(['gastronomia', 'naturaleza', 'cultura', 'eventos'] as $cat)
            <a href="{{ route('municipios.categoria.slug', [$item->departamento_slug, $item->slug, $cat]) }}" class="relative h-32 sm:h-36 md:h-48 lg:h-auto overflow-hidden rounded-[20px] md:rounded-[32px] group cursor-pointer w-full" aria-label="Explorar {{ $galleryImages[$cat]['title'] }} de {{ $item->nombre }}" style="background: {{ $galleryImages[$cat]['gradient'] }};">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:bg-gradient-to-t group-hover:from-black/70 group-hover:to-transparent transition-all"></div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="font-display text-sm md:text-base lg:text-lg font-bold">{{ $galleryImages[$cat]['title'] }}</div>
                    <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Explorar <i class="fas fa-arrow-right ml-1"></i></div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <!-- Fallback si no hay slugs -->
        <div class="col-span-full bg-white/80 backdrop-blur-sm p-4 md:p-6 text-center text-gray-500 rounded-[20px] md:rounded-[32px] shadow-lg">
            <p class="text-xs md:text-sm">Cargando galería...</p>
        </div>
        @endif
    </div>
</div>

<!-- Categorías de Puntos de Interés -->
<div id="lugares-destacados" class="mb-6 md:mb-8">
    @if(isset($item->categorias) && count($item->categorias) > 0)
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Lugares para Descubrir</h2>
    
    @foreach($item->categorias as $categoria => $items)
    <div class="mb-4 md:mb-8">
        <div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-4">
            @if($categoria == 'playas')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-umbrella-beach text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'museos')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-landmark text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'gastronomia')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-utensils text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'iglesias')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-church text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'parques_tematicos')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-violet-500 to-purple-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-ticket-alt text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'termales')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-hot-tub text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'deportes_aventura')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-bullseye text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'ciclismo')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center">
                <i class="fas fa-bicycle text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'desiertos_lagunas')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-sun text-white text-sm md:text-base"></i>
            </div>
            @elseif($categoria == 'islas')
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-water text-white text-sm md:text-base"></i>
            </div>
            @else
            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center">
                <i class="fas fa-star text-white text-sm md:text-base"></i>
            </div>
            @endif
            <h3 class="font-display text-base md:text-lg lg:text-xl xl:text-2xl font-bold text-midnight-900">
                {{ ucfirst(str_replace('_', ' ', $categoria)) }}
                <span class="text-xs md:text-sm lg:text-lg font-normal text-gray-500 ml-1 md:ml-2">({{ count($items) }})</span>
            </h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 min-w-0">
            @foreach($items as $item_cat)
            @php
                $hasImage = isset($item_cat->imagen) && $item_cat->imagen !== '';
                $hasCategoryRoute = isset($item->departamento_slug) && isset($item->slug) && isset($item_cat->slug);
                $categorySlug = str_replace('_', '-', $categoria);
            @endphp
            @if($hasCategoryRoute)
            <a href="{{ route('municipios.categoria.slug', [$item->departamento_slug, $item->slug, $categorySlug]) }}" class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full group cursor-pointer" aria-label="Ver {{ $item_cat->nombre }}">
            @else
            <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg w-full">
            @endif
                <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden w-full @if(!$hasImage) bg-gradient-to-br from-blue-600 to-indigo-700 @endif">
                    @if($hasImage)
                    <img src="{{ $item_cat->imagen }}" alt="{{ $item_cat->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy" decoding="async">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    @if(isset($item_cat->categoria))
                    <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-full text-[10px] md:text-xs text-gray-800 font-semibold z-10">
                        {{ $item_cat->categoria }}
                    </div>
                    @endif
                </div>
                <div class="p-3 md:p-5 bg-white">
                    <h4 class="font-display text-sm md:text-base lg:text-lg font-bold text-gray-900 mb-2">{{ $item_cat->nombre }}</h4>
                    <p class="text-gray-600 text-[10px] md:text-xs lg:text-sm line-clamp-2">{{ Str::limit($item_cat->descripcion, 100) }}</p>
                    @if($hasCategoryRoute)
                    <div class="mt-3 text-xs text-[#1D4ED8] font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                        Ver más <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                    @endif
                </div>
            @if($hasCategoryRoute)
            </a>
            @else
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@else
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 lg:p-8 lg:p-12 text-center text-gray-500 rounded-[20px] md:rounded-[32px] shadow-lg mb-6 md:mb-8">
    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
        <i class="fas fa-compass text-white text-2xl md:text-3xl"></i>
    </div>
    <h3 class="font-display text-lg md:text-xl lg:text-2xl font-bold text-gray-700 mb-2 md:mb-4">Estamos preparando nuevos lugares</h3>
    <p class="text-xs md:text-sm lg:text-base mb-4 md:mb-6 max-w-full md:max-w-2xl mx-auto">
        Muy pronto encontrarás recomendaciones, rutas y experiencias destacadas para explorar en {{ $item->nombre ?? 'este destino' }}.
    </p>
    <a href="{{ route('municipios.index') }}" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs md:text-sm hover:shadow-lg transition-all">
        <i class="fas fa-city mr-2"></i> Ver otros municipios
    </a>
</div>
@endif

<!-- Local Experiences -->
@if(isset($item->experiencias_locales) && count($item->experiencias_locales) > 0)
<div class="mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Experiencias Locales</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-6">
        @foreach($item->experiencias_locales as $exp)
        @php
            $gradient = getExperienceGradient($exp['category'] ?? 'General');
        @endphp
        <a href="{{ $exp['url'] ?? '#' }}" class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full group cursor-pointer" aria-label="Explorar {{ $exp['title'] }}">
            <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden w-full" style="background: {{ $gradient }};">
                @if(isset($exp['image_url']) && $exp['image_url'])
                <img src="{{ $exp['image_url'] }}" alt="{{ $exp['title'] }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold">{{ $exp['title'] }}</div>
                    <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">
                        {{ $exp['description'] ?? 'Explorar más' }} <i class="fas fa-arrow-right ml-1"></i>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@elseif(isset($item->experiencias_locales))
<!-- Empty State - No experiences available -->
<div class="mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Experiencias Locales</h2>
    <div class="bg-white/80 backdrop-blur-sm p-6 md:p-8 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
            <i class="fas fa-compass text-white text-2xl md:text-3xl"></i>
        </div>
        <h3 class="font-display text-lg md:text-xl font-bold text-gray-900 mb-2 md:mb-3">Estamos preparando experiencias locales</h3>
        <p class="text-gray-600 text-sm md:text-base mb-4 md:mb-6 max-w-md mx-auto">Pronto encontrarás actividades, sabores y lugares relacionados con {{ $item->nombre ?? 'este municipio' }}.</p>
        @if($item->departamento_slug && $item->slug)
        <a href="{{ route('municipios.categoria.slug', [$item->departamento_slug, $item->slug, 'naturaleza']) }}" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs md:text-sm hover:shadow-lg transition-all">
            <i class="fas fa-leaf mr-2"></i> Explorar categorías
        </a>
        @endif
    </div>
</div>
@endif

<!-- CTA Section -->
<div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] p-4 md:p-6 lg:p-8 lg:p-12 text-center text-white rounded-[20px] md:rounded-[32px] shadow-lg mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold mb-2 md:mb-4">Explora más de {{ $item->departamento_nombre ?? 'Colombia' }}</h2>
    <p class="text-xs md:text-sm lg:text-base lg:text-lg opacity-90 mb-4 md:mb-8 max-w-full md:max-w-2xl mx-auto">Descubre otros municipios increíbles</p>
    @if($item->departamento_slug)
    <a href="/municipios?departamento={{ $item->departamento_slug }}" class="inline-block w-full sm:w-auto px-4 py-3 md:px-8 md:py-4 bg-white text-[#1D4ED8] rounded-full font-semibold text-xs md:text-lg hover:shadow-2xl transition-all hover:scale-105">
        🗺️ Ver municipios de {{ $item->departamento_nombre }}
    </a>
    @else
    <a href="/municipios" class="inline-block w-full sm:w-auto px-4 py-3 md:px-8 md:py-4 bg-white text-[#1D4ED8] rounded-full font-semibold text-xs md:text-lg hover:shadow-2xl transition-all hover:scale-105">
        🗺️ Ver Todos los Municipios
    </a>
    @endif
</div>

<!-- Reviews Section -->
@include('components.reviews-section', [
    'reviewableType' => 'App\Models\Municipio',
    'reviewableId' => $item->id,
    'reviews' => $reviews ?? collect(),
    'averageRating' => $averageRating ?? 0,
    'reviewsCount' => $reviewsCount ?? 0,
])

<!-- Gastronomía del Departamento -->
@if(isset($item->platosTipicos) && $item->platosTipicos->count() > 0)
<div class="mb-6 md:mb-8">
    <div class="flex items-center justify-between mb-3 md:mb-6">
        <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900">Sabores del departamento de {{ $item->departamento_nombre }}</h2>
        <a href="{{ route('gastronomia') }}?departamento={{ $item->departamento_slug }}" class="text-sm md:text-base text-orange-600 hover:text-orange-700 font-semibold">
            Ver todos <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
        @foreach($item->platosTipicos as $plato)
        <a href="{{ route('gastronomia.show', [$plato->department_slug, $plato->slug]) }}" class="cinematic-card group cursor-pointer bg-white block">
            <div class="relative h-40 sm:h-48 overflow-hidden">
                @if($plato->imagen ?? null)
                    <img src="{{ $plato->imagen }}" alt="{{ $plato->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy" decoding="async">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center">
                        <span class="text-5xl">🍽️</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                
                <div class="absolute top-3 left-3 glass-badge bg-orange-500/30 text-[10px] md:text-xs">
                    {{ $plato->categoria ?? 'Plato Típico' }}
                </div>
            </div>
            
            <div class="p-4">
                <h3 class="font-display text-sm md:text-base font-bold text-gray-900 mb-1">{{ $plato->nombre }}</h3>
                <div class="flex items-center gap-1 text-[10px] md:text-xs text-gray-500">
                    <i class="fas fa-map-marker-alt text-orange-500"></i>
                    <span>{{ $plato->departamento }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<!-- Back Button -->
<div class="mb-4 md:mb-8">
    <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-4 py-2 md:px-6 md:py-3 bg-white/50 backdrop-blur-md text-gray-700 rounded-full font-semibold hover:bg-white/70 transition-all border border-gray-200 text-xs md:text-sm lg:text-base">
        <i class="fas fa-arrow-left text-xs md:text-sm lg:text-base"></i>
        Volver
    </a>
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
</div>

<script>
function toggleDescripcion() {
    const descripcion = document.getElementById('descripcion-hero');
    const btn = document.getElementById('btn-leer-mas');
    
    if (descripcion.classList.contains('line-clamp-4')) {
        descripcion.classList.remove('line-clamp-4');
        btn.textContent = 'Leer menos';
    } else {
        descripcion.classList.add('line-clamp-4');
        btn.textContent = 'Leer más';
    }
}

function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>
@endif
@endsection
