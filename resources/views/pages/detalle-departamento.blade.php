@extends('layouts.premium')

@section('title', $item->nombre ?? 'Detalle')

@section('content')
<!-- Main Container -->
<div class="detail-destination-page w-full min-w-0 overflow-x-hidden">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<!-- Hero Section -->
<div class="relative h-[40vh] sm:h-[50vh] md:h-[60vh] lg:h-[75vh] min-h-[300px] md:min-h-[400px] lg:min-h-[600px] overflow-hidden rounded-[24px] sm:rounded-[28px] md:rounded-[32px] mb-6 md:mb-8 w-full">
    @if($item->imagen)
        <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-[#07111F] via-[#0B1F2A] to-[#1D4ED8] flex items-center justify-center">
            <i class="fas fa-landmark text-white text-4xl md:text-5xl lg:text-8xl opacity-50"></i>
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
    
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="bg-white/90 backdrop-blur-sm inline-block mb-2 md:mb-6 px-2 py-1 md:px-4 md:py-2 rounded-full text-[10px] md:text-sm font-semibold text-gray-800 shadow-md z-10">
            🇨🇴 Departamento
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-7xl font-bold mb-2 md:mb-4 leading-tight" style="text-shadow: 2px 2px 12px rgba(0,0,0,0.8);">
            {{ $item->nombre }}
        </h1>
        <p id="descripcion-hero" class="text-xs md:text-sm lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-3xl mb-3 md:mb-8 line-clamp-4 md:line-clamp-none" style="text-shadow: 1px 1px 6px rgba(0,0,0,0.6);">
            {{ $item->descripcion ?? 'Descubre la magia de este increíble destino colombiano' }}
        </p>
        <button id="btn-leer-mas" onclick="toggleDescripcion()" class="md:hidden text-xs text-white/80 underline mb-3 md:mb-8">
            Leer más
        </button>
        <div class="flex flex-wrap gap-2 md:gap-4">
            <button onclick="scrollToSection('municipios-destacados')" class="w-full sm:w-auto px-4 py-3 md:px-8 md:py-4 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs md:text-lg hover:shadow-2xl transition-all hover:scale-105 cursor-pointer">
                🗺️ Explorar Municipios
            </button>
            <button onclick="scrollToSection('informacion-departamento')" class="w-full sm:w-auto px-4 py-3 md:px-8 md:py-4 bg-white/20 backdrop-blur-md text-white rounded-full font-semibold text-xs md:text-lg hover:bg-white/30 transition-all border border-white/30 cursor-pointer">
                📍 Ver Información
            </button>
        </div>
    </div>
</div>

<!-- Premium Stats -->
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[32px] shadow-lg">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">32</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Municipios</div>
        </div>
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">28°C</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Temperatura</div>
        </div>
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">4.9</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Calificación</div>
        </div>
        <div class="bg-white/90 backdrop-blur-sm p-3 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
            <div class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">150+</div>
            <div class="text-[10px] md:text-xs lg:text-sm text-gray-600 font-medium">Atracciones</div>
        </div>
    </div>
</div>

<!-- Department Info Section -->
<div id="informacion-departamento" class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[32px] shadow-lg">
        <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Información del Departamento</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
            <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 bg-white/50 rounded-2xl">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-map-marker-alt text-white text-lg md:text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] md:text-xs text-gray-500 font-medium">País</div>
                    <div class="font-bold text-midnight-900 text-sm md:text-base">Colombia</div>
                </div>
            </div>
            <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 bg-white/50 rounded-2xl">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-thermometer-half text-white text-lg md:text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] md:text-xs text-gray-500 font-medium">Clima</div>
                    <div class="font-bold text-midnight-900 text-sm md:text-base">Tropical</div>
                </div>
            </div>
            <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 bg-white/50 rounded-2xl">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-white text-lg md:text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] md:text-xs text-gray-500 font-medium">Población</div>
                    <div class="font-bold text-midnight-900 text-sm md:text-base">2.5M+</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visual Gallery -->
<div class="mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Galería Visual</h2>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 md:gap-4">
        @if($item->slug)
        @php
            $galleryImages = [
                'paisajes' => [
                    'gradient' => 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%)',
                    'title' => 'Paisajes',
                    'description' => 'Vistas panorámicas y paisajes naturales'
                ],
                'cultura' => [
                    'gradient' => 'linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%)',
                    'title' => 'Cultura',
                    'description' => 'Historia, tradiciones y patrimonio'
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
                'eventos' => [
                    'gradient' => 'linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%)',
                    'title' => 'Eventos',
                    'description' => 'Festivales y celebraciones'
                ]
            ];
        @endphp
        <a href="{{ route('departamentos.categoria.slug', [$item->slug, 'paisajes']) }}" class="lg:col-span-7 relative h-48 sm:h-56 md:h-64 lg:h-96 overflow-hidden rounded-[20px] md:rounded-[32px] group cursor-pointer w-full" aria-label="Explorar paisajes de {{ $item->nombre }}" style="background: {{ $galleryImages['paisajes']['gradient'] }};">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:bg-gradient-to-t group-hover:from-black/70 group-hover:to-transparent transition-all"></div>
            <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                <div class="font-display text-base md:text-lg lg:text-xl font-bold">{{ $galleryImages['paisajes']['title'] }}</div>
                <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Explorar <i class="fas fa-arrow-right ml-1"></i></div>
            </div>
        </a>
        <div class="lg:col-span-5 grid grid-cols-2 gap-3 md:gap-4">
            @foreach(['cultura', 'gastronomia', 'naturaleza', 'eventos'] as $cat)
            <a href="{{ route('departamentos.categoria.slug', [$item->slug, $cat]) }}" class="relative h-32 sm:h-36 md:h-48 lg:h-auto overflow-hidden rounded-[20px] md:rounded-[32px] group cursor-pointer w-full" aria-label="Explorar {{ $galleryImages[$cat]['title'] }} de {{ $item->nombre }}" style="background: {{ $galleryImages[$cat]['gradient'] }};">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:bg-gradient-to-t group-hover:from-black/70 group-hover:to-transparent transition-all"></div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="font-display text-sm md:text-base lg:text-lg font-bold">{{ $galleryImages[$cat]['title'] }}</div>
                    <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Explorar <i class="fas fa-arrow-right ml-1"></i></div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="col-span-full bg-white/80 backdrop-blur-sm p-4 md:p-6 text-center text-gray-500 rounded-[20px] md:rounded-[32px] shadow-lg">
            <p class="text-xs md:text-sm">Cargando galería...</p>
        </div>
        @endif
    </div>
</div>

<!-- Featured Destinations -->
<div id="municipios-destacados" class="mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Qué descubrir en {{ $item->nombre }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
        @forelse($item->municipios as $municipio)
        @php
            $departamentoSlug = $item->slug;
        @endphp
        <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
            <a href="{{ route('municipios.show.slugs', [$departamentoSlug, $municipio->slug]) }}" class="block">
                <div class="relative h-40 sm:h-48 md:h-56 overflow-hidden w-full">
                    @if($municipio->imagen)
                        <img src="{{ $municipio->imagen }}" alt="{{ $municipio->NOMBRE_MUNICIPIOS }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <span class="text-6xl">🏛️</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-3 right-3 md:bottom-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-full text-[10px] md:text-xs text-white z-10">
                        <span class="text-yellow-400">★</span> 4.8
                    </div>
                </div>
                <div class="p-3 md:p-5 bg-white">
                    <h3 class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold text-midnight-900 mb-2">{{ $municipio->NOMBRE_MUNICIPIOS }}</h3>
                    <p class="text-gray-600 text-[10px] md:text-xs lg:text-sm mb-2 md:mb-3 line-clamp-2">Descubre los tesoros ocultos de este municipio</p>
                    <div class="flex items-center gap-2 text-[10px] md:text-xs lg:text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt text-[#1D4ED8] text-[10px] md:text-xs lg:text-sm"></i>
                        <span>{{ $item->nombre }}</span>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-span-full glass-card p-4 md:p-6 lg:p-8 lg:p-12 text-center text-gray-500 rounded-[20px] md:rounded-[32px]">
            <i class="fas fa-city text-2xl md:text-3xl lg:text-4xl mb-2 md:mb-4 opacity-50"></i>
            <p class="text-xs md:text-sm lg:text-base lg:text-lg">Próximamente más destinos</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Local Experiences -->
<div class="mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-3 md:mb-6">Experiencias que debes vivir</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-6">
        @if($item->slug)
        <a href="{{ route('departamentos.categoria.slug', [$item->slug, 'cultura']) }}" class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full group cursor-pointer" aria-label="Explorar cultura cafetera">
            <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden w-full" style="background: linear-gradient(135deg, #92400e 0%, #78350f 50%, #451a03 100%);">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold">☕ Cultura Cafetera</div>
                    <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Ver cultura <i class="fas fa-arrow-right ml-1"></i></div>
                </div>
            </div>
        </a>
        <a href="{{ route('departamentos.categoria.slug', [$item->slug, 'naturaleza']) }}" class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full group cursor-pointer" aria-label="Explorar aventura">
            <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden w-full" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold">🏔️ Aventura</div>
                    <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Ver naturaleza <i class="fas fa-arrow-right ml-1"></i></div>
                </div>
            </div>
        </a>
        <a href="{{ route('departamentos.categoria.slug', [$item->slug, 'gastronomia']) }}" class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full group cursor-pointer" aria-label="Explorar gastronomía">
            <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden w-full" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%);">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold">🍽️ Gastronomía</div>
                    <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Ver sabores <i class="fas fa-arrow-right ml-1"></i></div>
                </div>
            </div>
        </a>
        <a href="{{ route('departamentos.categoria.slug', [$item->slug, 'eventos']) }}" class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full group cursor-pointer" aria-label="Explorar festivales">
            <div class="relative h-36 sm:h-40 md:h-48 overflow-hidden w-full" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%);">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold">🎉 Festivales</div>
                    <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Ver eventos <i class="fas fa-arrow-right ml-1"></i></div>
                </div>
            </div>
        </a>
        @else
        <div class="col-span-full bg-white/80 backdrop-blur-sm p-4 md:p-6 text-center text-gray-500 rounded-[20px] md:rounded-[32px] shadow-lg">
            <p class="text-xs md:text-sm">Cargando experiencias...</p>
        </div>
        @endif
    </div>
</div>

<!-- Gastronomía del Departamento -->
@if(isset($item->platosTipicos) && $item->platosTipicos->count() > 0)
<div class="mb-6 md:mb-8">
    <div class="flex items-center justify-between mb-3 md:mb-6">
        <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900">Gastronomía de {{ $item->nombre }}</h2>
        <a href="{{ route('gastronomia') }}?departamento={{ $item->slug }}" class="text-sm md:text-base text-orange-600 hover:text-orange-700 font-semibold">
            Ver todos <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
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

<!-- All Municipalities -->
<div class="mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-2 md:mb-3">Municipios de {{ $item->nombre }}</h2>
    <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6">Explora los municipios, pueblos y destinos que hacen parte de este departamento.</p>
    
    <!-- Search -->
    <div class="mb-6 md:mb-8">
        <div class="relative">
            <input 
                type="text" 
                id="municipio-search" 
                placeholder="Buscar municipio en {{ $item->nombre }}..." 
                class="w-full px-4 py-3 md:px-6 md:py-4 pl-12 md:pl-14 rounded-[20px] md:rounded-[28px] border border-gray-200 focus:border-[#1D4ED8] focus:ring-2 focus:ring-forest-200 outline-none transition-all text-sm md:text-base"
                data-department="{{ $item->slug }}"
            >
            <i class="fas fa-search absolute left-4 md:left-5 top-1/2 -translate-y-1/2 text-gray-400 text-sm md:text-base"></i>
        </div>
    </div>

    <!-- Municipalities Grid -->
    <div id="municipios-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        @forelse($item->municipios as $municipio)
        <a href="{{ route('municipios.show.slugs', [$item->slug, $municipio->slug]) }}" class="group rounded-[28px] overflow-hidden bg-white shadow-[0_12px_35px_rgba(0,0,0,0.10)] hover:shadow-[0_16px_40px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-300 cursor-pointer block w-full">
            <div class="relative h-48 md:h-56 overflow-hidden w-full">
                @if($municipio->imagen)
                    <img src="{{ $municipio->imagen }}" alt="{{ $municipio->NOMBRE_MUNICIPIOS }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-[#0f2d1a] to-[#10b981] flex items-center justify-center">
                        <div class="text-center text-white">
                            <span class="text-5xl md:text-6xl mb-2 block">🏛️</span>
                            <span class="text-sm md:text-base opacity-80">Imagen no disponible</span>
                        </div>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    <i class="fas fa-map-marker-alt text-[#1D4ED8] mr-1"></i> {{ $item->nombre }}
                </div>
            </div>
            <div class="p-5 md:p-6 bg-white">
                <h3 class="font-display text-lg md:text-xl font-bold text-midnight-900 mb-2">{{ $municipio->NOMBRE_MUNICIPIOS }}</h3>
                <p class="text-sm md:text-base text-gray-600 mb-4 line-clamp-2">
                    @if($municipio->DESCRIPCION)
                        {{ Str::limit($municipio->DESCRIPCION, 120) }}
                    @else
                        Explora este municipio del departamento de {{ $item->nombre }}.
                    @endif
                </p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
                        <i class="fas fa-city text-[#1D4ED8]"></i>
                        <span>Municipio</span>
                    </div>
                    <span class="text-[#1D4ED8] font-semibold text-xs md:text-sm flex items-center gap-2 group-hover:gap-3 transition-all">
                        Ver municipio <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full glass-card p-8 md:p-12 text-center text-gray-500 rounded-[28px]">
            <i class="fas fa-city text-4xl md:text-5xl mb-4 opacity-50"></i>
            <p class="text-base md:text-lg mb-2">No encontramos municipios registrados</p>
            <p class="text-sm md:text-base opacity-70">Pronto agregaremos municipios y destinos asociados a este departamento.</p>
        </div>
        @endforelse
    </div>

    <!-- Load More Button -->
    @if($item->allMunicipios->count() > 6)
    <div class="text-center mb-6 md:mb-8">
        <button 
            id="load-more-municipios" 
            class="w-full sm:w-auto px-6 py-3 md:px-8 md:py-4 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-sm md:text-base hover:shadow-2xl transition-all hover:scale-105"
            data-offset="6"
            data-department="{{ $item->slug }}"
            data-total="{{ $item->allMunicipios->count() }}"
        >
            Cargar más municipios
        </button>
    </div>
    @endif

    <!-- View All Button -->
    <div class="text-center mb-6 md:mb-8">
        <a href="/municipios?departamento={{ $item->slug }}" class="inline-block w-full sm:w-auto px-6 py-3 md:px-8 md:py-4 bg-white border-2 border-[#1D4ED8] text-[#1D4ED8] rounded-full font-semibold text-sm md:text-base hover:bg-f[#1D4ED8]/1 transition-all">
            Ver todos los municipios de {{ $item->nombre }}
        </a>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] p-4 md:p-6 lg:p-8 lg:p-12 text-center text-white rounded-[20px] md:rounded-[32px] shadow-lg mb-6 md:mb-8">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold mb-2 md:mb-4">Explora más lugares de Colombia</h2>
    <p class="text-xs md:text-sm lg:text-base lg:text-lg opacity-90 mb-4 md:mb-8 max-w-full md:max-w-2xl mx-auto">Descubre otros departamentos increíbles</p>
    <a href="/departamentos" class="inline-block w-full sm:w-auto px-4 py-3 md:px-8 md:py-4 bg-white text-[#1D4ED8] rounded-full font-semibold text-xs md:text-lg hover:shadow-2xl transition-all hover:scale-105">
        🗺️ Ver Todos los Departamentos
    </a>
</div>

<!-- Back Button -->
<div class="mb-4 md:mb-8">
    <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-4 py-2 md:px-6 md:py-3 bg-white/50 backdrop-blur-md text-gray-700 rounded-full font-semibold hover:bg-white/70 transition-all border border-gray-200 text-xs md:text-sm lg:text-base">
        <i class="fas fa-arrow-left text-xs md:text-sm lg:text-base"></i>
        Volver
    </a>
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

<!-- Cierre del contenedor principal -->
</div>
</div>

<script>
// Municipios data from server
const allMunicipios = @json($item->allMunicipios);
const departmentSlug = '{{ $item->slug }}';
const departmentName = '{{ $item->nombre }}';

// Search functionality
const searchInput = document.getElementById('municipio-search');
const municipiosGrid = document.getElementById('municipios-grid');

if (searchInput) {
    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredMunicipios = allMunicipios.filter(municipio => 
            municipio.NOMBRE_MUNICIPIOS.toLowerCase().includes(searchTerm)
        );
        renderMunicipios(filteredMunicipios);
    });
}

// Render municipalities
function renderMunicipios(municipios) {
    if (!municipiosGrid) return;
    
    if (municipios.length === 0) {
        municipiosGrid.innerHTML = `
            <div class="col-span-full glass-card p-8 md:p-12 text-center text-gray-500 rounded-[28px]">
                <i class="fas fa-search text-4xl md:text-5xl mb-4 opacity-50"></i>
                <p class="text-base md:text-lg mb-2">No encontramos municipios con ese nombre</p>
                <p class="text-sm md:text-base opacity-70">Intenta con otro término de búsqueda.</p>
            </div>
        `;
        return;
    }
    
    municipiosGrid.innerHTML = municipios.map(municipio => {
        const imagenHtml = municipio.imagen 
            ? `<img src="${municipio.imagen}" alt="${municipio.NOMBRE_MUNICIPIOS}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">`
            : `<div class="w-full h-full bg-gradient-to-br from-[#0f2d1a] to-[#10b981] flex items-center justify-center">
                <div class="text-center text-white">
                    <span class="text-5xl md:text-6xl mb-2 block">🏛️</span>
                    <span class="text-sm md:text-base opacity-80">Imagen no disponible</span>
                </div>
            </div>`;
        
        const descripcion = municipio.DESCRIPCION 
            ? municipio.DESCRIPCION.substring(0, 120) + (municipio.DESCRIPCION.length > 120 ? '...' : '')
            : `Explora este municipio del departamento de ${departmentName}.`;
        
        return `
            <a href="/municipios/${departmentSlug}/${municipio.slug}" class="group rounded-[28px] overflow-hidden bg-white shadow-[0_12px_35px_rgba(0,0,0,0.10)] hover:shadow-[0_16px_40px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-300 cursor-pointer block w-full">
                <div class="relative h-48 md:h-56 overflow-hidden w-full">
                    ${imagenHtml}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                        <i class="fas fa-map-marker-alt text-[#1D4ED8] mr-1"></i> ${departmentName}
                    </div>
                </div>
                <div class="p-5 md:p-6 bg-white">
                    <h3 class="font-display text-lg md:text-xl font-bold text-midnight-900 mb-2">${municipio.NOMBRE_MUNICIPIOS}</h3>
                    <p class="text-sm md:text-base text-gray-600 mb-4 line-clamp-2">${descripcion}</p>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
                            <i class="fas fa-city text-[#1D4ED8]"></i>
                            <span>Municipio</span>
                        </div>
                        <span class="text-[#1D4ED8] font-semibold text-xs md:text-sm flex items-center gap-2 group-hover:gap-3 transition-all">
                            Ver municipio <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
        `;
    }).join('');
}

// Load more functionality
const loadMoreBtn = document.getElementById('load-more-municipios');
if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
        const offset = parseInt(this.dataset.offset);
        const total = parseInt(this.dataset.total);
        const nextOffset = offset + 6;
        
        const moreMunicipios = allMunicipios.slice(offset, nextOffset);
        const currentMunicipios = Array.from(municipiosGrid.children);
        
        moreMunicipios.forEach(municipio => {
            const imagenHtml = municipio.imagen 
                ? `<img src="${municipio.imagen}" alt="${municipio.NOMBRE_MUNICIPIOS}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">`
                : `<div class="w-full h-full bg-gradient-to-br from-[#0f2d1a] to-[#10b981] flex items-center justify-center">
                    <div class="text-center text-white">
                        <span class="text-5xl md:text-6xl mb-2 block">🏛️</span>
                        <span class="text-sm md:text-base opacity-80">Imagen no disponible</span>
                    </div>
                </div>`;
            
            const descripcion = municipio.DESCRIPCION 
                ? municipio.DESCRIPCION.substring(0, 120) + (municipio.DESCRIPCION.length > 120 ? '...' : '')
                : `Explora este municipio del departamento de ${departmentName}.`;
            
            const card = document.createElement('a');
            card.href = `/municipios/${departmentSlug}/${municipio.slug}`;
            card.className = 'group rounded-[28px] overflow-hidden bg-white shadow-[0_12px_35px_rgba(0,0,0,0.10)] hover:shadow-[0_16px_40px_rgba(0,0,0,0.15)] hover:-translate-y-1 transition-all duration-300 cursor-pointer block w-full';
            card.innerHTML = `
                <div class="relative h-48 md:h-56 overflow-hidden w-full">
                    ${imagenHtml}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                        <i class="fas fa-map-marker-alt text-[#1D4ED8] mr-1"></i> ${departmentName}
                    </div>
                </div>
                <div class="p-5 md:p-6 bg-white">
                    <h3 class="font-display text-lg md:text-xl font-bold text-midnight-900 mb-2">${municipio.NOMBRE_MUNICIPIOS}</h3>
                    <p class="text-sm md:text-base text-gray-600 mb-4 line-clamp-2">${descripcion}</p>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
                            <i class="fas fa-city text-[#1D4ED8]"></i>
                            <span>Municipio</span>
                        </div>
                        <span class="text-[#1D4ED8] font-semibold text-xs md:text-sm flex items-center gap-2 group-hover:gap-3 transition-all">
                            Ver municipio <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            `;
            municipiosGrid.appendChild(card);
        });
        
        this.dataset.offset = nextOffset;
        
        if (nextOffset >= total) {
            this.style.display = 'none';
        }
    });
}

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
@endsection
