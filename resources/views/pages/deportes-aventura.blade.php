@extends('layouts.premium')

@section('title', 'Deportes de Aventura')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Premium Redesign - Full Background Image -->
<div class="relative h-[230px] sm:h-[250px] md:h-[280px] lg:h-[300px] xl:h-[340px] overflow-hidden rounded-[32px] mb-8 md:mb-12">
    <!-- Full background image - Adventure landscape -->
    <img
        src="https://m.rutascolombia.com/Imagenes_app/turismo_de_salud/termales_de_san_juan_purace.jpg"
        alt="Paisaje de aventura en Colombia"
        class="absolute inset-0 w-full h-full object-cover"
        loading="eager"
        fetchpriority="high"
    >

    <!-- Progressive overlay - left to right gradient for text legibility -->
    <div class="absolute inset-0" style="background: linear-gradient(to right, #c2410c 0%, #c2410c 40%, rgba(194, 65, 12, 0.7) 60%, rgba(194, 65, 12, 0.3) 80%, rgba(194, 65, 12, 0.1) 100%);"></div>

    <!-- Bottom overlay for content integration -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#c2410c]/30 via-transparent to-transparent"></div>

    <!-- Decorative texture overlay - subtle geographic pattern -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>

    <!-- Main content - centered vertically -->
    <div class="absolute inset-0 flex items-center p-6 md:p-10 lg:p-16">
        <div class="relative z-10 max-w-2xl">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full mb-4 md:mb-6">
                <span class="w-2 h-2 bg-orange-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-xs md:text-sm font-medium tracking-wide uppercase">🧗 Turismo y Aventura</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-3 md:mb-4 leading-tight" style="text-shadow: 0 2px 20px rgba(0,0,0,0.3);">
                Deportes de Aventura
            </h1>

            <!-- Description -->
            <p class="text-white/80 text-sm md:text-base lg:text-lg mb-6 md:mb-8 max-w-xl leading-relaxed">
                Vive la adrenalina en los paisajes más espectaculares de Colombia
            </p>

            <!-- Chips -->
            <div class="flex flex-wrap gap-2 md:gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-hiking text-xs md:text-sm"></i> Aventura
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-bolt text-xs md:text-sm"></i> Adrenalina
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-leaf text-xs md:text-sm"></i> Naturaleza
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-mountain text-xs md:text-sm"></i> Extremo
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <i class="fas fa-shield-alt text-xs md:text-sm"></i> Seguro
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Métricas Elegantes -->
<div class="mb-12 md:mb-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">{{ $total ?? $items->count() }}</div>
            <div class="text-gray-600 text-sm font-medium">Actividades</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">{{ $destinosCount ?? 1 }}</div>
            <div class="text-gray-600 text-sm font-medium">Destinos</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">3</div>
            <div class="text-gray-600 text-sm font-medium">Niveles</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">🛡️</div>
            <div class="text-gray-600 text-sm font-medium">Seguridad</div>
        </div>
    </div>
</div>

<!-- Actividades Destacadas -->
<div class="mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Actividades Destacadas</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12">
        @forelse($items as $item)
        <x-cards.tourism-card
            :id="$item->id"
            :title="$item->nombre"
            :description="$item->descripcion ?? 'Información turística en actualización.'"
            :image="$item->imagen"
            :badge="'🧗 Aventura'"
            :location="'Colombia'"
            :secondaryLocation="$item->municipios ?? null"
            :detailUrl="route('puntos-interes.deportes-aventura.show', $item->id)"
            :fallbackTheme="'adventure'"
        />
        @empty
        <div class="col-span-full text-center py-16 text-gray-500">
            <i class="fas fa-mountain text-6xl mb-4 text-gray-300"></i>
            <p class="text-lg">No hay deportes de aventura registrados en este momento.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($total > $perPage)
@php
    $totalPages = ceil($total / $perPage);
    $startPage = max(1, $page - 2);
    $endPage = min($totalPages, $page + 2);
@endphp
<div class="mb-12 md:mb-16">
    <div class="flex justify-center items-center gap-2">
        @if($page > 1)
            <a href="?page={{ $page - 1 }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @for($i = $startPage; $i <= $endPage; $i++)
            @if($i == $page)
                <span class="px-4 py-2 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold">{{ $i }}</span>
            @else
                <a href="?page={{ $i }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">{{ $i }}</a>
            @endif
        @endfor

        @if($page < $totalPages)
            <a href="?page={{ $page + 1 }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">
                <i class="fas fa-chevron-right"></i>
            </a>
        @endif
    </div>
</div>
@endif

<!-- CTA Final -->
<div class="mb-12 md:mb-16">
    <div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] rounded-[32px] p-8 md:p-12 text-center text-white">
        <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">Explora Más Actividades</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Descubre otras categorías de turismo y aventura en Colombia</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('puntos-interes.ciclismo') }}" class="px-8 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
                🚴 Ciclismo
            </a>
            <a href="{{ route('puntos-interes.reservas-naturales') }}" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                🏞️ Reservas Naturales
            </a>
            <a href="{{ route('puntos-interes.parques-tematicos') }}" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                🎢 Parques Temáticos
            </a>
        </div>
    </div>
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
@endsection
