@extends('layouts.premium')

@section('title', 'Departamentos')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Premium Redesign - Full Background Image -->
<div class="relative h-[230px] sm:h-[250px] md:h-[280px] lg:h-[300px] xl:h-[340px] overflow-hidden rounded-[32px] mb-8 md:mb-12 w-full">
    <!-- Full background image - Cartagena coastal landscape -->
    <img
        src="https://m.rutascolombia.com/Imagenes_app/capital_cities/cartagena/cartagena.jpg"
        alt="Paisaje costero de Cartagena, Colombia"
        class="absolute inset-0 w-full h-full object-cover"
        loading="eager"
        fetchpriority="high"
    >

    <!-- Progressive overlay - left to right gradient for text legibility -->
    <div class="absolute inset-0" style="background: linear-gradient(to right, #0c4a6e 0%, #0c4a6e 40%, rgba(12, 74, 110, 0.7) 60%, rgba(12, 74, 110, 0.3) 80%, rgba(12, 74, 110, 0.1) 100%);"></div>

    <!-- Bottom overlay for content integration -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#0c4a6e]/30 via-transparent to-transparent"></div>

    <!-- Decorative texture overlay - subtle geographic pattern -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>

    <!-- Main content - centered vertically -->
    <div class="absolute inset-0 flex items-center p-6 md:p-10 lg:p-16">
        <div class="relative z-10 max-w-2xl">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full mb-4 md:mb-6">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-xs md:text-sm font-medium tracking-wide uppercase">🗺️ 6 Regiones Naturales</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-3 md:mb-4 leading-tight" style="text-shadow: 0 2px 20px rgba(0,0,0,0.3);">
                Departamentos de Colombia
            </h1>

            <!-- Description -->
            <p class="text-white/80 text-sm md:text-base lg:text-lg mb-6 md:mb-8 max-w-xl leading-relaxed">
                Explora las 6 regiones naturales y sus 32 departamentos
            </p>

            <!-- Decorative chips -->
            <div class="flex flex-wrap gap-2 md:gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-map text-xs md:text-sm"></i> Caribe
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-mountain text-xs md:text-sm"></i> Andina
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-water text-xs md:text-sm"></i> Pacífica
                </span>
            </div>
        </div>
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

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12">

    @forelse($items as $item)
    <x-cards.tourism-card
        :id="$item->id"
        :title="$item->nombre"
        :description="$item->descripcion ?? 'Información turística en actualización.'"
        :image="$item->imagen"
        :badge="'🏛️ Departamento'"
        :location="$item->region ? 'Región: ' . $item->region : 'Colombia'"
        :detailUrl="route('departamentos.show', $item->id)"
        :fallbackTheme="'nature'"
    />
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
