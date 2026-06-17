@extends('layouts.premium')

@section('title', 'Departamentos')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Immersive -->
<div class="hero-section rounded-[28px] md:rounded-[32px] mb-8 md:mb-12 w-full overflow-hidden relative min-h-[420px] md:min-h-[460px]" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);">
    <div class="hero-overlay rounded-[28px] md:rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-8 lg:p-10 xl:p-16 text-white">
        <div class="glass-badge inline-block mb-3 md:mb-4 lg:mb-6">
            🗺️ 6 Regiones Naturales
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-2 md:mb-3 lg:mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Departamentos de Colombia
        </h1>
        <p class="text-sm md:text-base lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Explora las 6 regiones naturales y sus 32 departamentos
        </p>
    </div>
</div>

<!-- Region Filters -->
<div class="glass-card p-4 md:p-6 mb-8 md:mb-12 rounded-[20px] md:rounded-[32px]">
    <div class="flex gap-2 md:gap-3 overflow-x-auto whitespace-nowrap pb-2 md:pb-0 scrollbar-hide">
        <a href="/departamentos" class="px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-gradient-to-r from-forest-500 to-forest-600 text-white shadow-lg hover:shadow-xl whitespace-nowrap flex-shrink-0">
            Todas
        </a>
        <a href="/regiones/caribe" class="px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80 whitespace-nowrap flex-shrink-0">
            🌴 Caribe
        </a>
        <a href="/regiones/andina" class="px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80 whitespace-nowrap flex-shrink-0">
            ⛰️ Andina
        </a>
        <a href="/regiones/pacifica" class="px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80 whitespace-nowrap flex-shrink-0">
            🌊 Pacífica
        </a>
        <a href="/regiones/amazonia" class="px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80 whitespace-nowrap flex-shrink-0">
            🌿 Amazonía
        </a>
        <a href="/regiones/llanos" class="px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80 whitespace-nowrap flex-shrink-0">
            🌾 Llanos
        </a>
        <a href="/regiones/insular" class="px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80 whitespace-nowrap flex-shrink-0">
            🏝️ Insular
        </a>
    </div>
</div>

<!-- All Departments -->
<h2 class="font-display text-xl sm:text-2xl md:text-3xl font-bold text-midnight-900 mb-4 md:mb-6">Todos los Departamentos</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">

    @forelse($items as $item)
    @php
        $deptUrl = $item->slug ? '/departamentos/' . $item->slug : '#';
    @endphp
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        @if($deptUrl !== '#')
        <a href="{{ $deptUrl }}" class="block">
        @else
        <div class="block opacity-50 cursor-not-allowed">
        @endif
            <div class="relative h-48 sm:h-52 md:h-56 overflow-hidden w-full">
                @if($item->imagen)
                    <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <span class="text-6xl">🏛️</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    <i class="fas fa-landmark mr-1 text-xs md:text-sm"></i> Departamento
                </div>
            </div>
            <div class="p-4 md:p-6 bg-white">
                <h3 class="font-display text-base md:text-lg lg:text-xl xl:text-2xl font-bold text-gray-900 mb-2">{{ $item->nombre }}</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">{{ Str::limit($item->descripcion, 100) ?? 'Departamento de Colombia' }}</p>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt text-indigo-500 text-xs md:text-sm"></i>
                        <span>Colombia</span>
                    </div>
                    @if($deptUrl !== '#')
                    <span class="text-indigo-600 font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Ver más <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                    @else
                    <span class="text-gray-400 font-semibold text-xs md:text-sm">
                        No disponible
                    </span>
                    @endif
                </div>
            </div>
        @if($deptUrl !== '#')
        </a>
        @else
        </div>
        @endif
    </div>
    @empty
    <div class="col-span-full glass-card p-8 md:p-12 text-center text-gray-500">
        <i class="fas fa-map text-3xl md:text-4xl mb-3 md:mb-4 opacity-50"></i>
        <p class="text-sm md:text-lg">No hay departamentos registrados en este momento.</p>
    </div>
    @endforelse
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
@endsection
