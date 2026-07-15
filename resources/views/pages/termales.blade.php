@extends('layouts.premium')

@section('title', 'Termales')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Premium Redesign - Full Background Image -->
<div class="relative h-[230px] sm:h-[250px] md:h-[280px] lg:h-[300px] xl:h-[340px] overflow-hidden rounded-[32px] mb-8 md:mb-12">
    <!-- Full background image - Thermal waters landscape -->
    <img
        src="https://m.rutascolombia.com/Imagenes_app/turismo_de_salud/termales_de_san_juan_purace.jpg"
        alt="Aguas termales en Colombia"
        class="absolute inset-0 w-full h-full object-cover"
        loading="eager"
        fetchpriority="high"
    >

    <!-- Progressive overlay - left to right gradient for text legibility -->
    <div class="absolute inset-0" style="background: linear-gradient(to right, #0d9488 0%, #0d9488 40%, rgba(13, 148, 136, 0.7) 60%, rgba(13, 148, 136, 0.3) 80%, rgba(13, 148, 136, 0.1) 100%);"></div>

    <!-- Bottom overlay for content integration -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#0d9488]/30 via-transparent to-transparent"></div>

    <!-- Decorative texture overlay - subtle water/steam pattern -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>

    <!-- Main content - centered vertically -->
    <div class="absolute inset-0 flex items-center p-6 md:p-10 lg:p-16">
        <div class="relative z-10 max-w-2xl">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full mb-4 md:mb-6">
                <span class="w-2 h-2 bg-teal-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-xs md:text-sm font-medium tracking-wide uppercase">🧖 Naturaleza</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-3 md:mb-4 leading-tight" style="text-shadow: 0 2px 20px rgba(0,0,0,0.3);">
                Aguas Termales
            </h1>

            <!-- Description -->
            <p class="text-white/80 text-sm md:text-base lg:text-lg mb-6 md:mb-8 max-w-xl leading-relaxed">
                Relájate en los manantiales de aguas calientes de Colombia
            </p>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="mb-8 md:mb-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white rounded-[24px] p-4 md:p-6 text-center shadow-sm">
            <div class="text-3xl md:text-5xl font-bold text-[#0d9488] mb-2">{{ $items->count() }}</div>
            <div class="text-gray-600 text-xs md:text-sm font-medium">Termales</div>
        </div>
        <div class="bg-white rounded-[24px] p-4 md:p-6 text-center shadow-sm">
            <div class="text-3xl md:text-5xl font-bold text-[#0d9488] mb-2">38°C</div>
            <div class="text-gray-600 text-xs md:text-sm font-medium">Temperatura Promedio</div>
        </div>
        <div class="bg-white rounded-[24px] p-4 md:p-6 text-center shadow-sm">
            <div class="text-3xl md:text-5xl font-bold text-[#0d9488] mb-2">6</div>
            <div class="text-gray-600 text-xs md:text-sm font-medium">Departamentos</div>
        </div>
        <div class="bg-white rounded-[24px] p-4 md:p-6 text-center shadow-sm">
            <div class="text-3xl md:text-5xl font-bold text-[#0d9488] mb-2">100%</div>
            <div class="text-gray-600 text-xs md:text-sm font-medium">Natural</div>
        </div>
    </div>
</div>

<!-- Termales Destacados -->
<div class="mb-8 md:mb-12">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Termales Destacados</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12">

        @forelse($items as $item)
        <x-cards.tourism-card
            :id="$item->id"
            :title="$item->nombre"
            :description="$item->descripcion ?? 'Información turística en actualización.'"
            :image="$item->imagen"
            :badge="'🧖 Termales'"
            :location="$item->locality_departamento ?? 'Colombia'"
            :secondaryLocation="$item->locality_municipio"
            :detailUrl="route('puntos-interes.termales.show', $item->id)"
            :fallbackTheme="'nature'"
        />
        @empty
        <div class="col-span-full text-center py-16 text-gray-500">
            <i class="fas fa-hot-tub text-6xl mb-4 text-gray-300"></i>
            <p class="text-lg">No hay termales registrados en este momento.</p>
        </div        >
        @endforelse

    </div>
</div>

<!-- Explorar Más -->
<div class="mb-8 md:mb-12">
    <div class="bg-gradient-to-r from-[#0d9488] to-[#0f766e] rounded-[32px] p-8 md:p-12 text-center text-white">
        <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">Explora Más Destinos</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Descubre otras categorías de naturaleza en Colombia</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('puntos-interes.playas') }}" class="px-8 py-3 bg-white text-[#0d9488] rounded-full font-semibold hover:shadow-lg transition-all">
                🏖️ Playas
            </a>
            <a href="{{ route('puntos-interes.islas') }}" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                🏝️ Islas
            </a>
            <a href="{{ route('puntos-interes.reservas-naturales') }}" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                🏞️ Reservas Naturales
            </a>
        </div>
    </div>
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
@endsection
