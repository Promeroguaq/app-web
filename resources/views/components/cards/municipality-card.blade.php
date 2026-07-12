@props([
    'id' => null,
    'nombre' => '',
    'descripcion' => '',
    'departamento' => '',
    'region' => null,
    'imagen' => null,
    'slug' => '',
    'departamentoSlug' => ''
])

@php
    // Determine premium fallback gradient based on region
    $fallbackGradient = 'linear-gradient(135deg, #1D4ED8 0%, #1E40AF 100%)';
    
    if ($region) {
        $regionLower = strtolower($region);
        if (str_contains($regionLower, 'amazon') || str_contains($regionLower, 'pacífico')) {
            $fallbackGradient = 'linear-gradient(135deg, #065f46 0%, #1e3a5f 100%)';
        } elseif (str_contains($regionLower, 'caribe') || str_contains($regionLower, 'costa')) {
            $fallbackGradient = 'linear-gradient(135deg, #0ea5e9 0%, #f59e0b 100%)';
        } elseif (str_contains($regionLower, 'andina') || str_contains($regionLower, 'cafe')) {
            $fallbackGradient = 'linear-gradient(135deg, #059669 0%, #64748b 100%)';
        } elseif (str_contains($regionLower, 'llano')) {
            $fallbackGradient = 'linear-gradient(135deg, #d97706 0%, #0c4a6e 100%)';
        }
    }
    
    // Generar ruta usando slugs de departamento y municipio
    // departmentSlug desde $departamento (de tabla_localities)
    // municipalitySlug desde $nombre (de tabla_municipios)
    $route = $departamentoSlug 
        ? route('municipios.show.slugs', [
            'departmentSlug' => $departamentoSlug,
            'municipalitySlug' => $slug
        ])
        : route('municipios.show', $id);
@endphp

<div class="municipality-card group relative w-full bg-white rounded-2xl md:rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
    <!-- Image Section -->
    <div class="relative h-48 md:h-56 lg:h-64 overflow-hidden">
        @if($imagen)
            <img 
                src="{{ $imagen }}" 
                alt="{{ $nombre }}" 
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy"
            >
        @else
            <div class="w-full h-full flex items-center justify-center" style="background: {{ $fallbackGradient }};">
                <div class="text-center">
                    <i class="fas fa-city text-white/30 text-4xl md:text-5xl mb-2"></i>
                    <p class="text-white/20 text-xs font-medium">{{ $departamento ?? 'Colombia' }}</p>
                </div>
            </div>
        @endif
        
        <!-- Badge -->
        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-[10px] md:text-xs font-semibold text-gray-700 shadow-sm z-10">
            🏙️ Municipio
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="p-4 md:p-5 lg:p-6">
        <!-- Title -->
        <h3 class="font-display text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2 md:mb-3 leading-tight">
            {{ $nombre }}
        </h3>
        
        <!-- Description -->
        <p class="text-gray-600 text-sm md:text-base line-clamp-3 leading-relaxed mb-3 md:mb-4 min-h-[3rem] md:min-h-[4.5rem]">
            {{ $descripcion }}
        </p>
        
        <!-- Location -->
        @if($departamento)
        <div class="flex items-center gap-2 text-gray-500 text-xs md:text-sm mb-4">
            <i class="fas fa-map-marker-alt text-gray-400"></i>
            <span class="font-medium">{{ $departamento }}</span>
        </div>
        @endif
        
        <!-- Action -->
        <a href="{{ $route }}" class="inline-flex items-center gap-2 text-sm md:text-base font-semibold text-[#1D4ED8] hover:text-[#1E40AF] transition-colors group-hover:gap-3">
            Ver detalle
            <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
        </a>
    </div>
</div>
