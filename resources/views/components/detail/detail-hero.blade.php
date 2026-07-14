@props([
    'title' => '',
    'subtitle' => '',
    'image' => null,
    'badge' => null,
    'location' => null,
    'fallbackTheme' => 'nature'
])

@php
    $themes = [
        'nature' => 'from-emerald-600 to-teal-700',
        'city' => 'from-blue-600 to-indigo-700',
        'beach' => 'from-cyan-500 to-blue-600',
        'culture' => 'from-amber-600 to-orange-700',
        'adventure' => 'from-green-600 to-emerald-700',
        'gastronomy' => 'from-orange-500 to-red-600',
    ];
    $gradient = $themes[$fallbackTheme] ?? $themes['nature'];
@endphp

<!-- Hero Section -->
<div class="relative h-[45vh] sm:h-[50vh] md:h-[55vh] lg:h-[60vh] min-h-[320px] md:min-h-[400px] overflow-hidden rounded-[20px] sm:rounded-[24px] md:rounded-[28px] mb-6 md:mb-8 w-full">
    @if($image)
        <img src="{{ $image }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
            <div class="text-center text-white">
                <i class="fas fa-map-marker-alt text-4xl md:text-5xl lg:text-6xl opacity-30 mb-4"></i>
                <p class="text-sm md:text-base opacity-50">Imagen no disponible</p>
            </div>
        </div>
    @endif
    
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 lg:p-10 text-white">
        @if($badge)
            <div class="bg-white/90 backdrop-blur-sm inline-block mb-2 md:mb-4 px-3 py-1 md:px-4 md:py-1.5 rounded-full text-[10px] md:text-xs font-semibold text-gray-800 shadow-md">
                {{ $badge }}
            </div>
        @endif
        
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-2 md:mb-3 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">
            {{ $title }}
        </h1>
        
        @if($subtitle)
            <p class="text-sm md:text-base lg:text-lg opacity-90 mb-3 md:mb-4" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">
                {{ $subtitle }}
            </p>
        @endif
        
        @if($location)
            <div class="flex items-center gap-2 text-xs md:text-sm text-white/80">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $location }}</span>
            </div>
        @endif
    </div>
</div>
