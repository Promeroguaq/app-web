@extends('layouts.premium')

@section('title', 'Regiones Naturales')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            Geografía
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Regiones de Colombia
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Explora las 6 regiones naturales del país
        </p>
    </div>
</div>

<!-- Stats Section -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">6</div>
        <div class="text-sm text-gray-600">Regiones</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">32</div>
        <div class="text-sm text-gray-600">Departamentos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">1.1M</div>
        <div class="text-sm text-gray-600">km²</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">100%</div>
        <div class="text-sm text-gray-600">Diversidad</div>
    </div>
</div>

<!-- Regions Grid -->
<div class="flex items-center gap-3 mb-8">
    <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Regiones Naturales</h2>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">
    @foreach($regions as $region)
    <a href="{{ route('regiones.show', ['slug' => $region->slug]) }}" class="group block">
        <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full h-full">
            <!-- Image Area -->
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" @if($region->image_url) style="background-image: url('{{ $region->image_url }}'); background-size: cover; background-position: center;" @else style="background: linear-gradient(135deg, {{ $region->color }} 0%, {{ $region->color }}dd 50%, {{ $region->color }}bb 100%);" @endif>
                @if($region->image_url)
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                @endif
                
                <!-- Top Left Badge -->
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    {{ $region->shortName }}
                </div>
                
                <!-- Top Right Counter -->
                <div class="absolute top-3 right-3 md:top-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-medium text-white z-10">
                    {{ $region->departments_count }} {{ $region->departments_count == 1 ? 'depto' : 'deptos' }}
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="p-4 md:p-6 bg-white">
                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2">{{ $region->name }}</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">{{ $region->description }}</p>
                
                <!-- Department Chips -->
                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                    @foreach($region->visible_departments as $dept)
                    <span class="px-2 py-1 md:px-3 md:py-1 bg-{{ $region->accent }}-100 text-{{ $region->accent }}-700 rounded-full text-[10px] md:text-xs font-medium">
                        {{ $dept->name }}
                    </span>
                    @endforeach
                    @if($region->remaining_departments > 0)
                    <span class="px-2 py-1 md:px-3 md:py-1 bg-{{ $region->accent }}-100 text-{{ $region->accent }}-700 rounded-full text-[10px] md:text-xs font-medium">
                        +{{ $region->remaining_departments }}
                    </span>
                    @endif
                </div>
                
                <!-- Mini Statistics -->
                @if($region->municipios_count > 0)
                <div class="flex items-center gap-2 mb-3 md:mb-4 text-xs md:text-sm text-gray-600">
                    <span class="font-semibold text-{{ $region->accent }}-600">{{ $region->municipios_count }} municipios</span>
                </div>
                @endif
                
                <!-- Action -->
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <span class="text-{{ $region->accent }}-600 font-semibold text-xs md:text-sm flex items-center gap-2 group-hover:gap-3 transition-all">
                        Explorar región <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>

<!-- CTA Section -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Destinos</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
        Descubre los departamentos de cada región
    </p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/departamentos" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            Departamentos
        </a>
        <a href="/playas" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Playas
        </a>
        <a href="/destinos" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Reservas Naturales
        </a>
    </div>
</div>

</div>
@endsection
