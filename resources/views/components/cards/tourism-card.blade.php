@props([
    'id' => null,
    'title' => '',
    'description' => '',
    'image' => null,
    'badge' => null,
    'location' => '',
    'secondaryLocation' => null,
    'detailUrl' => '#',
    'fallbackTheme' => 'default'
])

@php
    // Determine premium fallback gradient based on theme
    $fallbackGradient = 'linear-gradient(135deg, #1D4ED8 0%, #1E40AF 100%)';
    
    switch ($fallbackTheme) {
        case 'capital':
            $fallbackGradient = 'linear-gradient(135deg, #1e3a5f 0%, #3b82f6 100%)';
            break;
        case 'nature':
            $fallbackGradient = 'linear-gradient(135deg, #065f46 0%, #14b8a6 100%)';
            break;
        case 'culture':
            $fallbackGradient = 'linear-gradient(135deg, #92400e 0%, #d97706 100%)';
            break;
        case 'adventure':
            $fallbackGradient = 'linear-gradient(135deg, #c2410c 0%, #ea580c 100%)';
            break;
        case 'beach':
            $fallbackGradient = 'linear-gradient(135deg, #0ea5e9 0%, #f59e0b 100%)';
            break;
        case 'caribe':
            $fallbackGradient = 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)';
            break;
        case 'llanos':
            $fallbackGradient = 'linear-gradient(135deg, #84cc16 0%, #65a30d 100%)';
            break;
        case 'andina':
            $fallbackGradient = 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)';
            break;
        case 'pacifica':
            $fallbackGradient = 'linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%)';
            break;
        case 'centro':
            $fallbackGradient = 'linear-gradient(135deg, #6366f1 0%, #4f46e5 100%)';
            break;
        case 'amazonia':
            $fallbackGradient = 'linear-gradient(135deg, #059669 0%, #047857 100%)';
            break;
        default:
            $fallbackGradient = 'linear-gradient(135deg, #1D4ED8 0%, #1E40AF 100%)';
    }
@endphp

<div class="tourism-card group relative w-full h-full bg-white rounded-2xl md:rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 flex flex-col">
    <!-- Image Section -->
    <div class="relative h-52 sm:h-56 shrink-0 overflow-hidden">
        @if($image)
            <div class="relative w-full h-full">
                <img 
                    src="{{ $image }}" 
                    alt="{{ $title }}" 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    loading="lazy"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-700 to-teal-500 flex items-center justify-center" style="display: none;">
                    <div class="text-center text-white/60">
                        <span class="text-5xl">🗺️</span>
                    </div>
                </div>
            </div>
        @else
            <div class="w-full h-full flex items-center justify-center" style="background: {{ $fallbackGradient }};">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt text-white/30 text-4xl md:text-5xl mb-2"></i>
                    <p class="text-white/20 text-xs font-medium">{{ $location ?? 'Colombia' }}</p>
                </div>
            </div>
        @endif
        
        <!-- Badge -->
        @if($badge)
        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-[10px] md:text-xs font-semibold text-gray-700 shadow-sm z-10">
            {{ $badge }}
        </div>
        @endif
    </div>
    
    <!-- Content Section -->
    <div class="flex flex-1 flex-col p-5">
        <!-- Title -->
        <h3 class="font-display text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2 md:mb-3 leading-tight line-clamp-2 min-h-[2.5rem]">
            {{ $title }}
        </h3>
        
        <!-- Description -->
        <p class="text-gray-600 text-sm md:text-base line-clamp-3 leading-relaxed mb-3 md:mb-4 min-h-[4.5rem]">
            {{ $description }}
        </p>
        
        <!-- Location -->
        @if($location)
        <div class="flex items-center gap-2 text-gray-500 text-xs md:text-sm mb-2">
            <i class="fas fa-map-marker-alt text-gray-400"></i>
            <span class="font-medium">{{ $location }}</span>
        </div>
        @endif
        
        <!-- Secondary Location -->
        @if($secondaryLocation)
        <div class="flex items-center gap-2 text-gray-400 text-xs mb-4">
            <i class="fas fa-compass text-gray-300"></i>
            <span>{{ $secondaryLocation }}</span>
        </div>
        @endif
        
        <!-- Action -->
        <div class="mt-auto pt-3">
            <a href="{{ $detailUrl }}" class="inline-flex items-center gap-2 text-sm md:text-base font-semibold text-[#1D4ED8] hover:text-[#1E40AF] transition-colors group-hover:gap-3">
                Ver más
                <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</div>
