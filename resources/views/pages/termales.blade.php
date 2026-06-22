@extends('layouts.premium')

@section('title', 'Termales')

@section('content')
<!-- Hero Premium Redesign - Full Background Image -->
<div class="relative h-[230px] sm:h-[250px] md:h-[280px] lg:h-[300px] xl:h-[340px] overflow-hidden rounded-[32px] mb-8 md:mb-12 max-w-7xl mx-auto">
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
<div class="max-w-7xl mx-auto mb-8 md:mb-12">
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
<div class="max-w-7xl mx-auto mb-8 md:mb-12">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Termales Destacados</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5 md:gap-6">

        @forelse($items as $item)
        <a href="{{ route('puntos-interes.termales.show', $item->id) }}" class="block text-decoration-none">
            <div class="rounded-[28px] overflow-hidden bg-white shadow-[0_10px_35px_rgba(0,0,0,0.10)] hover:-translate-y-2 hover:scale-[1.01] transition-all duration-500 cursor-pointer group flex flex-col h-full">
                <div class="relative h-[160px] sm:h-[180px] overflow-hidden">
                    @if($item->imagen)
                        <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <!-- Elegant teal overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#0f766e]/70 via-[#0d9488]/50 to-[#14b8a6]/40"></div>
                        <!-- Bottom gradient for text legibility -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0f766e]/80 via-transparent to-transparent"></div>
                    @else
                        <!-- Premium fallback with water/steam pattern -->
                        <div class="w-full h-full bg-gradient-to-br from-[#0f766e] via-[#0d9488] to-[#14b8a6] relative overflow-hidden">
                            <!-- Subtle water texture -->
                            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 30% 40%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 70% 60%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>
                            <!-- Steam effect -->
                            <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-[#0f766e]/50 to-transparent"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-hot-tub text-white/20 text-8xl"></i>
                            </div>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white/10 backdrop-blur-md border border-white/20 px-3 py-1.5 rounded-full text-xs text-white font-semibold">
                        🧖 Termales
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                        <div class="flex gap-4 text-sm font-medium">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-temperature-high"></i> Aguas Calientes
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="fas fa-spa"></i> Relax
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-5 md:p-6 flex flex-col flex-grow">
                    <h3 class="font-display text-lg md:text-xl font-bold text-gray-900 mb-2">{{ $item->nombre }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">{{ $item->descripcion }}</p>
                    <div class="flex items-center gap-2 text-sm text-gray-600 mt-auto">
                        <i class="fas fa-map-marker-alt text-[#0d9488]"></i>
                        <span>Colombia</span>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16 text-gray-500">
            <i class="fas fa-hot-tub text-6xl mb-4 text-gray-300"></i>
            <p class="text-lg">No hay termales registrados en este momento.</p>
        </div>
        @endforelse

    </div>
</div>

<!-- Explorar Más -->
<div class="max-w-7xl mx-auto mb-8 md:mb-12">
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
@endsection
