@extends('layouts.premium')

@section('title', $title ?? 'Detalle de Categoría')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Cinematic Hero Section -->
<div class="relative h-[65vh] md:h-[75vh] min-h-[500px] md:min-h-[600px] overflow-hidden rounded-[32px] mb-12 md:mb-16">
    <img src="{{ $heroImage }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/70 to-black/40"></div>
    
    <div class="absolute top-4 left-4 md:top-6 md:left-6">
        <div class="bg-white/90 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
            {{ ucfirst(str_replace('_', ' ', $category)) }}
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="flex flex-wrap gap-2 md:gap-3 mb-4 md:mb-6">
            @foreach($badges as $badge)
            <div class="bg-white/20 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm text-white border border-white/30">
                {{ $badge }}
            </div>
            @endforeach
        </div>
        
        <h1 class="font-display text-3xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-3 md:mb-4 leading-tight" style="text-shadow: 2px 2px 16px rgba(0,0,0,0.9);">
            {{ $title }}
        </h1>
        
        <p class="text-base md:text-lg lg:text-xl xl:text-2xl opacity-95 max-w-3xl mb-6 md:mb-8" style="text-shadow: 1px 1px 8px rgba(0,0,0,0.8);">
            {{ $subtitle }}
        </p>
        
        <div class="flex flex-wrap gap-3 md:gap-4">
            <button onclick="document.getElementById('featured-section').scrollIntoView({behavior: 'smooth'})" class="px-6 py-3 md:px-8 md:py-4 bg-white text-midnight-900 rounded-full font-semibold hover:bg-white/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 text-sm md:text-base">
                🗺️ Explorar contenido
            </button>
            <button onclick="document.getElementById('location-section').scrollIntoView({behavior: 'smooth'})" class="px-6 py-3 md:px-8 md:py-4 bg-white/20 backdrop-blur-md text-white rounded-full font-semibold hover:bg-white/30 transition-all border border-white/30 text-sm md:text-base">
                📍 Ver mapa
            </button>
        </div>
    </div>
</div>

<!-- Storytelling Introduction -->
<div class="my-12 md:my-16">
    <div class="bg-white/80 backdrop-blur-sm p-6 md:p-8 lg:p-12 bg-gradient-to-br from-[#F7F3EA] to-[#f0ebe3] rounded-[32px] shadow-lg">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-book-open text-white text-2xl md:text-3xl"></i>
            </div>
            <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-4 md:mb-6">
                {{ ucfirst(str_replace('_', ' ', $category)) }} de {{ $entityName }}
            </h2>
            <p class="text-base md:text-lg lg:text-xl text-gray-700 leading-relaxed mb-6">
                {{ $description }}
            </p>
            @if(count($mainTopics) > 0)
            <div class="flex flex-wrap justify-center gap-2 md:gap-3">
                @foreach($mainTopics as $topic)
                <div class="bg-white/60 backdrop-blur-sm px-3 py-1.5 md:px-4 md:py-2 rounded-full text-sm md:text-base text-[#1D4ED8] border border-f[#1D4ED8]/0">
                    {{ $topic }}
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Immersive Gallery -->
<div class="mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-6 md:mb-8">
        Galería Visual
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <div class="col-span-1 sm:col-span-2 row-span-2 relative h-64 md:h-96 lg:h-[500px] overflow-hidden rounded-[32px] group cursor-pointer" onclick="openGalleryModal(0)">
            <img src="{{ $gallery[0]['image'] }}" alt="{{ $gallery[0]['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-4 left-4 md:bottom-6 md:left-6 text-white z-10">
                <div class="font-display text-xl md:text-2xl lg:text-3xl font-bold">{{ $gallery[0]['title'] }}</div>
                <div class="text-xs md:text-sm opacity-0 group-hover:opacity-100 transition-opacity mt-1">Click para ver más</div>
            </div>
        </div>

        @foreach(array_slice($gallery, 1) as $index => $item)
        <div class="relative h-48 md:h-64 overflow-hidden rounded-[32px] group cursor-pointer" onclick="openGalleryModal({{ $index + 1 }})">
            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                <div class="font-display text-base md:text-lg font-bold">{{ $item['title'] }}</div>
                <div class="text-[10px] md:text-xs opacity-0 group-hover:opacity-100 transition-opacity mt-1">Click para ver más</div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Featured Places -->
<div id="featured-section" class="mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-6 md:mb-8">
        {{ $featuredItemsTitle }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($featuredPlaces as $index => $place)
        @php
            $hasValidUrl = isset($place['url']) && $place['url'] !== '#';
        @endphp
        <div class="rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            @if($hasValidUrl)
            <a href="{{ $place['url'] }}" class="block">
            @else
            <div class="block cursor-pointer" onclick="openItemModal({{ $index }})">
            @endif
                <div class="relative h-56 md:h-64 overflow-hidden">
                    <img src="{{ $place['image'] }}" alt="{{ $place['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs text-white z-10">
                        <span class="text-yellow-400">★</span> {{ $place['rating'] }}
                    </div>
                </div>
                <div class="p-5 md:p-6 bg-white">
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                        <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                        <span>{{ $place['location'] }}</span>
                    </div>
                    <h3 class="font-display text-xl md:text-2xl font-bold text-gray-900 mb-2">{{ $place['name'] }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $place['description'] }}</p>
                    @if($hasValidUrl)
                    <button class="w-full px-4 py-2 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all text-sm">
                        Ver detalle
                    </button>
                    @else
                    <button class="w-full px-4 py-2 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all text-sm">
                        Ver más
                    </button>
                    @endif
                </div>
            @if($hasValidUrl)
            </a>
            @else
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<!-- Local Experiences -->
<div class="mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-6 md:mb-8">
        {{ $experiencesTitle }}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        @foreach($experiences as $index => $experience)
        @php
            $hasRoute = isset($experience['route']) && $experience['route'] !== '#' && $experience['route'] !== '';
        @endphp
        @if($hasRoute)
        <a href="{{ $experience['route'] }}" class="relative min-h-[260px] rounded-[32px] overflow-hidden shadow-[0_16px_45px_rgba(0,0,0,0.16)] group cursor-pointer transition-all duration-500 hover:-translate-y-2 hover:scale-[1.01] block">
        @else
        <div class="relative min-h-[260px] rounded-[32px] overflow-hidden shadow-[0_16px_45px_rgba(0,0,0,0.16)] group cursor-pointer transition-all duration-500 hover:-translate-y-2 hover:scale-[1.01]" onclick="openExperienceModal({{ $index }})">
        @endif
            <img src="{{ $experience['image'] }}" alt="{{ $experience['title'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/10"></div>
            <div class="absolute inset-0 flex flex-col justify-between p-6 text-white">
                <div class="text-xs bg-white/20 backdrop-blur-md rounded-full px-3 py-1 w-fit">
                    {{ $experience['badge'] }}
                </div>
                <div>
                    <div class="font-display text-lg md:text-xl font-bold mb-2">{{ $experience['title'] }}</div>
                    <p class="text-sm opacity-90 line-clamp-2">{{ $experience['description'] }}</p>
                    @if(!$hasRoute)
                    <div class="mt-3 text-xs text-white/80 opacity-0 group-hover:opacity-100 transition-opacity">
                        Click para ver detalles
                    </div>
                    @endif
                </div>
            </div>
        @if($hasRoute)
        </a>
        @else
        </div>
        @endif
        @endforeach
    </div>
</div>

<!-- Events Section -->
@if($category === 'eventos' && count($events) > 0)
<div class="mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-6 md:mb-8">
        Eventos Destacados
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($events as $event)
        <div class="bg-white/80 backdrop-blur-sm p-6 bg-gradient-to-br from-amber-50 to-orange-50 rounded-[32px] shadow-lg">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar-alt text-white text-2xl"></i>
                </div>
                <div class="flex-1">
                    <div class="text-sm text-amber-600 font-semibold mb-1">{{ $event['date'] }}</div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-2">{{ $event['name'] }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ $event['description'] }}</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt text-amber-500"></i>
                        <span>{{ $event['location'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif


<!-- Location/Map Section -->
<div id="location-section" class="mb-12 md:mb-16">
    <div class="bg-white/80 backdrop-blur-sm p-8 md:p-12 bg-gradient-to-br from-midnight-900 to-forest-900 rounded-[32px] text-white shadow-lg">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-map-marked-alt text-white text-3xl"></i>
            </div>
            <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">
                Ubicación de {{ $entityName }}
            </h2>
            <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
                Descubre dónde vivir estas experiencias únicas en el corazón de Colombia.
            </p>
            <button class="px-8 py-4 bg-white text-midnight-900 rounded-full font-semibold hover:bg-white/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                📍 Abrir ubicación
            </button>
        </div>
    </div>
</div>

<!-- Related Destinations -->
@if(count($relatedDestinations) > 0)
<div class="mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-6 md:mb-8">
        También te puede interesar
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        @foreach($relatedDestinations as $destination)
        <div class="rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <a href="{{ $destination['url'] }}" class="block">
                <div class="relative h-40 md:h-48 overflow-hidden">
                    <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white z-10">
                        <div class="font-display text-base md:text-lg font-bold">{{ $destination['name'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Final CTA -->
<div class="mb-12 md:mb-16">
    <div class="relative h-[400px] md:h-[500px] overflow-hidden rounded-[32px]" style="background: linear-gradient(135deg, #0f2d1a 0%, #10b981 50%, #059669 100%);">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/60 to-black/40"></div>
        
        <div class="absolute inset-0 flex items-center justify-center p-4 md:p-8">
            <div class="text-center text-white max-w-3xl">
                <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6">
                    Explora más lugares de Colombia
                </h2>
                <p class="text-lg md:text-xl opacity-90 mb-6 md:mb-8">
                    Descubre otros destinos increíbles con experiencias únicas
                </p>
                <a href="/departamentos" class="inline-block px-8 py-4 bg-white text-midnight-900 rounded-full font-semibold hover:bg-white/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 text-base md:text-lg">
                    🗺️ Ver todos los destinos
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="mb-8">
    <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-6 py-3 bg-white/50 backdrop-blur-md text-gray-700 rounded-full font-semibold hover:bg-white/70 transition-all border border-gray-200">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>

<!-- Item Detail Modal -->
<div id="itemModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeItemModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-[#f8f5f0] rounded-[32px] max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-[0_30px_80px_rgba(0,0,0,0.35)] transform transition-all">
            <div class="relative">
                <img id="modalImage" src="" alt="" class="w-full h-[220px] md:h-[340px] object-cover rounded-t-[32px]">
                <button onclick="closeItemModal()" class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-lg">
                    <i class="fas fa-times text-gray-700"></i>
                </button>
                <div class="absolute bottom-4 left-4">
                    <span id="modalCategory" class="inline-block bg-[#1D4ED8]/10 text-[#1D4ED8] px-3 py-1 rounded-full text-sm font-semibold backdrop-blur-sm"></span>
                </div>
            </div>
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                    <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                    <span id="modalLocation"></span>
                </div>
                <h3 id="modalTitle" class="font-display text-2xl md:text-3xl font-bold text-[#0f2d1a] mb-4"></h3>
                <p id="modalDescription" class="text-gray-700 mb-6 leading-relaxed text-base"></p>

                <!-- Información práctica -->
                <div id="modalPracticalInfo" class="hidden mb-6 p-4 bg-white rounded-2xl">
                    <h4 class="font-semibold text-[#0f2d1a] mb-3">Información práctica</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div id="modalScheduleContainer" class="hidden">
                            <div class="text-gray-500">Horario</div>
                            <div id="modalSchedule" class="font-medium text-[#0f2d1a]"></div>
                        </div>
                        <div id="modalPriceContainer" class="hidden">
                            <div class="text-gray-500">Precio</div>
                            <div id="modalPrice" class="font-medium text-[#0f2d1a]"></div>
                        </div>
                    </div>
                </div>

                <!-- Rating y acciones -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div id="modalRatingContainer" class="hidden flex items-center gap-1 text-yellow-500">
                            <i class="fas fa-star"></i>
                            <span id="modalRating" class="font-semibold text-[#0f2d1a]"></span>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-wrap gap-3">
                    <button id="modalViewDetailBtn" onclick="closeItemModal()" class="hidden px-6 py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all">
                        Ver detalle completo
                    </button>
                    <button id="modalViewMapBtn" class="hidden px-6 py-3 bg-white text-[#0f2d1a] rounded-full font-semibold hover:bg-gray-100 transition-all border border-gray-200">
                        <i class="fas fa-map-marked-alt mr-2"></i>Ver en mapa
                    </button>
                    <button onclick="document.getElementById('featured-section').scrollIntoView({behavior: 'smooth'}); closeItemModal();" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition-all">
                        Explorar lugares relacionados
                    </button>
                    <button onclick="closeItemModal()" class="px-6 py-3 bg-transparent text-gray-600 rounded-full font-semibold hover:bg-gray-100 transition-all">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeGalleryModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-[#f8f5f0] rounded-[32px] max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-[0_30px_80px_rgba(0,0,0,0.35)] transform transition-all">
            <div class="relative">
                <img id="galleryModalImage" src="" alt="" class="w-full h-[220px] md:h-[340px] object-cover rounded-t-[32px]">
                <button onclick="closeGalleryModal()" class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-lg">
                    <i class="fas fa-times text-gray-700"></i>
                </button>
                <div class="absolute bottom-4 left-4">
                    <span class="inline-block bg-[#1D4ED8]/10 text-[#1D4ED8] px-3 py-1 rounded-full text-sm font-semibold backdrop-blur-sm">
                        {{ ucfirst(str_replace('_', ' ', $category)) }}
                    </span>
                </div>
            </div>
            <div class="p-6 md:p-8">
                <h3 id="galleryModalTitle" class="font-display text-2xl md:text-3xl font-bold text-[#0f2d1a] mb-4"></h3>
                <p id="galleryModalDescription" class="text-gray-700 mb-6 leading-relaxed text-base"></p>
                <div class="flex flex-wrap gap-3">
                    <button onclick="closeGalleryModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition-all">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Experience Modal -->
<div id="experienceModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeExperienceModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-[#f8f5f0] rounded-[32px] max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-[0_30px_80px_rgba(0,0,0,0.35)] transform transition-all">
            <div class="relative">
                <img id="experienceModalImage" src="" alt="" class="w-full h-[220px] md:h-[340px] object-cover rounded-t-[32px]">
                <button onclick="closeExperienceModal()" class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-lg">
                    <i class="fas fa-times text-gray-700"></i>
                </button>
                <div class="absolute bottom-4 left-4">
                    <span id="experienceModalBadge" class="inline-block bg-[#1D4ED8]/10 text-[#1D4ED8] px-3 py-1 rounded-full text-sm font-semibold backdrop-blur-sm"></span>
                </div>
            </div>
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                    <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                    <span>{{ $entityName }}</span>
                </div>
                <h3 id="experienceModalTitle" class="font-display text-2xl md:text-3xl font-bold text-[#0f2d1a] mb-4"></h3>
                <p id="experienceModalDescription" class="text-gray-700 mb-6 leading-relaxed text-base"></p>

                <!-- Información práctica -->
                <div id="experienceModalPracticalInfo" class="hidden mb-6 p-4 bg-white rounded-2xl">
                    <h4 class="font-semibold text-[#0f2d1a] mb-3">Información práctica</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div id="experienceModalScheduleContainer" class="hidden">
                            <div class="text-gray-500">Horario</div>
                            <div id="experienceModalSchedule" class="font-medium text-[#0f2d1a]"></div>
                        </div>
                        <div id="experienceModalPriceContainer" class="hidden">
                            <div class="text-gray-500">Precio</div>
                            <div id="experienceModalPrice" class="font-medium text-[#0f2d1a]"></div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button onclick="closeExperienceModal()" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition-all">
                        Cerrar
                    </button>
                    <button onclick="document.getElementById('featured-section').scrollIntoView({behavior: 'smooth'}); closeExperienceModal();" class="px-6 py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all">
                        Explorar lugares relacionados
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Featured places data for modal
const featuredPlacesData = @json($featuredPlaces);

// Gallery data for modal
const galleryData = @json($gallery);

// Experiences data for modal
const experiencesData = @json($experiences);

function openItemModal(index) {
    const item = featuredPlacesData[index];
    if (!item) return;

    // Log warning if no real description
    if (!item.description || item.description.includes('Descubre la belleza de')) {
        console.warn("Item without real description:", item);
    }

    document.getElementById('modalImage').src = item.image;
    document.getElementById('modalTitle').textContent = item.name;
    document.getElementById('modalDescription').textContent = item.description;
    document.getElementById('modalLocation').textContent = item.location;
    document.getElementById('modalCategory').textContent = '{{ ucfirst(str_replace('_', ' ', $category)) }}';

    // Show/hide rating
    if (item.rating) {
        document.getElementById('modalRating').textContent = item.rating;
        document.getElementById('modalRatingContainer').classList.remove('hidden');
    } else {
        document.getElementById('modalRatingContainer').classList.add('hidden');
    }

    // Show/hide practical info
    const hasPracticalInfo = item.schedule || item.price;
    if (hasPracticalInfo) {
        document.getElementById('modalPracticalInfo').classList.remove('hidden');
        if (item.schedule) {
            document.getElementById('modalSchedule').textContent = item.schedule;
            document.getElementById('modalScheduleContainer').classList.remove('hidden');
        } else {
            document.getElementById('modalScheduleContainer').classList.add('hidden');
        }
        if (item.price) {
            document.getElementById('modalPrice').textContent = item.price;
            document.getElementById('modalPriceContainer').classList.remove('hidden');
        } else {
            document.getElementById('modalPriceContainer').classList.add('hidden');
        }
    } else {
        document.getElementById('modalPracticalInfo').classList.add('hidden');
    }

    // Show/hide view detail button
    if (item.url && item.url !== '#') {
        document.getElementById('modalViewDetailBtn').classList.remove('hidden');
        document.getElementById('modalViewDetailBtn').onclick = function() {
            window.location.href = item.url;
        };
    } else {
        document.getElementById('modalViewDetailBtn').classList.add('hidden');
    }

    // Show/hide view map button
    if (item.coordinates || item.latitude || item.mapsUrl) {
        document.getElementById('modalViewMapBtn').classList.remove('hidden');
        const mapUrl = item.mapsUrl || `https://maps.google.com/?q=${item.latitude || ''},${item.longitude || ''}`;
        document.getElementById('modalViewMapBtn').onclick = function() {
            window.open(mapUrl, '_blank');
        };
    } else {
        document.getElementById('modalViewMapBtn').classList.add('hidden');
    }

    document.getElementById('itemModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeItemModal() {
    document.getElementById('itemModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openGalleryModal(index) {
    const item = galleryData[index];
    if (!item) return;

    document.getElementById('galleryModalImage').src = item.image;
    document.getElementById('galleryModalTitle').textContent = item.title;
    document.getElementById('galleryModalDescription').textContent = item.description || 'Descubre este aspecto de ' + '{{ $entityName }}';

    document.getElementById('galleryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    document.getElementById('galleryModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openExperienceModal(index) {
    const item = experiencesData[index];
    if (!item) return;

    // Log warning if no real description
    if (!item.description || item.description.includes('Descubre la belleza de')) {
        console.warn("Experience without real description:", item);
    }

    document.getElementById('experienceModalImage').src = item.image;
    document.getElementById('experienceModalTitle').textContent = item.title;
    document.getElementById('experienceModalDescription').textContent = item.description;
    document.getElementById('experienceModalBadge').textContent = item.badge;

    // Show/hide practical info
    const hasPracticalInfo = item.schedule || item.price;
    if (hasPracticalInfo) {
        document.getElementById('experienceModalPracticalInfo').classList.remove('hidden');
        if (item.schedule) {
            document.getElementById('experienceModalSchedule').textContent = item.schedule;
            document.getElementById('experienceModalScheduleContainer').classList.remove('hidden');
        } else {
            document.getElementById('experienceModalScheduleContainer').classList.add('hidden');
        }
        if (item.price) {
            document.getElementById('experienceModalPrice').textContent = item.price;
            document.getElementById('experienceModalPriceContainer').classList.remove('hidden');
        } else {
            document.getElementById('experienceModalPriceContainer').classList.add('hidden');
        }
    } else {
        document.getElementById('experienceModalPracticalInfo').classList.add('hidden');
    }

    document.getElementById('experienceModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeExperienceModal() {
    document.getElementById('experienceModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Close modals on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeItemModal();
        closeGalleryModal();
        closeExperienceModal();
    }
});
</script>

</div>
@endsection
