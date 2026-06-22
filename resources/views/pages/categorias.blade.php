@extends('layouts.premium')

@section('title', 'Categorías Turísticas')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Premium Redesign - Full Background Image -->
<div class="relative h-[250px] sm:h-[280px] md:h-[300px] lg:h-[340px] overflow-hidden rounded-[32px] mb-8 md:mb-12 w-full">
    <!-- Full background image -->
    <img
        src="https://m.rutascolombia.com/Imagenes_app/fotos_regions/regioncafetera.jpg"
        alt="Paisaje cafetero colombiano"
        class="absolute inset-0 w-full h-full object-cover"
        loading="eager"
        fetchpriority="high"
    >

    <!-- Progressive overlay - left to right gradient for text legibility -->
    <div class="absolute inset-0" style="background: linear-gradient(to right, #0c4a6e 0%, #0c4a6e 40%, rgba(12, 74, 110, 0.7) 60%, rgba(12, 74, 110, 0.3) 80%, rgba(12, 74, 110, 0.1) 100%);"></div>

    <!-- Bottom overlay for content integration -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#0c4a6e]/30 via-transparent to-transparent"></div>

    <!-- Decorative texture overlay -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>

    <!-- Main content - centered vertically -->
    <div class="absolute inset-0 flex items-center p-6 md:p-10 lg:p-16">
        <div class="relative z-10 max-w-2xl">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full mb-4 md:mb-6">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-white/90 text-xs md:text-sm font-medium tracking-wide uppercase">Explora Colombia</span>
            </div>

            <!-- Title -->
            <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-3 md:mb-4 leading-tight" style="text-shadow: 0 2px 20px rgba(0,0,0,0.3);">
                Categorías Turísticas
            </h1>

            <!-- Description -->
            <p class="text-white/80 text-sm md:text-base lg:text-lg mb-6 md:mb-8 max-w-xl leading-relaxed">
                Descubre todos los destinos, experiencias y maravillas de Colombia
            </p>

            <!-- Chips -->
            <div class="flex flex-wrap gap-2 md:gap-3 mb-6 md:mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    Destinos
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/></svg>
                    Naturaleza
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 md:px-4 md:py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-white/90 text-xs md:text-sm font-medium hover:bg-white/15 transition-all cursor-default">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.276.649l-1.652 4.324a1 1 0 00.594 1.28l5.758 2.376a1 1 0 001.148-.594l2.376-5.758a1 1 0 00-.594-1.28l-4.324-1.652a1 1 0 01-.649-.276L11.25 6.92a1 1 0 001.84 0l7-3z"/></svg>
                    Cultura
                </span>
            </div>

            <!-- Scroll button -->
            <a href="#filtros" class="inline-flex items-center gap-2 text-white/70 hover:text-white/90 text-sm font-medium transition-all group">
                <span>Explorar categorías</span>
                <svg class="w-4 h-4 transform group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- Premium Filters -->
<div id="filtros" class="bg-white/80 backdrop-blur-sm p-3 md:p-4 lg:p-6 mb-8 md:mb-12 rounded-[20px] md:rounded-[32px] shadow-lg">
    <div class="flex flex-wrap gap-2 md:gap-3 justify-center">
        <button onclick="filterCategories('Todas')" class="filter-btn active px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-gradient-to-r from-forest-500 to-forest-600 text-white shadow-lg" data-filter="Todas">
            Todas
        </button>
        <button onclick="filterCategories('Geográficas')" class="filter-btn px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80" data-filter="Geográficas">
            🗺️ Geográficas
        </button>
        <button onclick="filterCategories('Turismo')" class="filter-btn px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80" data-filter="Turismo">
            🧗 Turismo
        </button>
        <button onclick="filterCategories('Cultural')" class="filter-btn px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80" data-filter="Cultural">
            🏛️ Cultura
        </button>
        <button onclick="filterCategories('Naturaleza')" class="filter-btn px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80" data-filter="Naturaleza">
            🌿 Naturaleza
        </button>
        <button onclick="filterCategories('Gastronomía')" class="filter-btn px-3 py-2 md:px-6 md:py-3 rounded-full font-semibold text-xs md:text-sm transition-all bg-white/50 text-gray-600 hover:bg-white/80" data-filter="Gastronomía">
            🍽️ Gastronomía
        </button>
    </div>
</div>

<!-- Categories Grid -->
<div id="categorias-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12">
    
    @foreach($categorias as $categoria)
    @php
        $colorMap = [
            'primary' => '#3b82f6',
            'info' => '#0ea5e9',
            'success' => '#10b981',
            'warning' => '#f59e0b',
            'danger' => '#ef4444',
            'purple' => '#8b5cf6',
            'indigo' => '#6366f1',
            'orange' => '#f97316',
            'secondary' => '#64748b'
        ];
        $bgColor = $colorMap[$categoria['color']] ?? '#3b82f6';
        
        $categoriaGradients = [
            'Deportes de aventura' => 'linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%)',
            'Ciclismo' => 'linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%)',
            'Termales' => 'linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%)',
            'Playas' => 'linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%)',
            'Reservas de parques' => 'linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%)',
            'Actividades de parques' => 'linear-gradient(135deg, #84cc16 0%, #65a30d 50%, #4d7c0f 100%)',
            'Museos' => 'linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%)',
            'Iglesias' => 'linear-gradient(135deg, #92400e 0%, #78350f 50%, #451a03 100%)',
            'Parques temáticos' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%)',
            'Gastronomía' => 'linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%)',
            'Destinos' => 'linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%)',
            'Departamentos' => 'linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%)',
            'Municipios' => 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%)',
            'Eventos' => 'linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%)',
            'Alojamiento' => 'linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%)',
            'Agencias' => 'linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%)'
        ];
        $categoriaGradient = $categoriaGradients[$categoria['nombre']] ?? 'linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%)';
    @endphp
    
    <div class="categoria-card rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full flex flex-col min-h-[240px] md:min-h-[260px]" data-tipo="{{ $categoria['tipo'] }}" onclick="window.location.href='{{ $categoria['ruta'] }}'">
        <div class="relative h-[88px] sm:h-[92px] md:h-[96px] lg:h-[100px] overflow-hidden w-full flex-shrink-0" style="background: {{ $categoriaGradient }};">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-2.5 left-2.5 md:top-3 md:left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 md:px-3 md:py-1.5 rounded-full text-[11px] md:text-xs font-semibold text-gray-800 shadow-md z-10">
                {{ $categoria['nombre'] }}
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-2.5 md:p-3 text-white z-10">
                <div class="text-2xl md:text-3xl font-bold font-display leading-none">{{ $categoria['count'] }}</div>
                <div class="text-[11px] md:text-xs opacity-90 mt-0.5">Registros</div>
            </div>
        </div>
        <div class="p-4 md:p-5 bg-white flex-1 flex flex-col">
            <h3 class="font-display text-base md:text-lg font-bold text-gray-900 mb-2 leading-tight">{{ $categoria['nombre'] }}</h3>
            <p class="text-sm md:text-base text-gray-600 mb-4 line-clamp-2 leading-relaxed flex-1">{{ $categoria['descripcion'] }}</p>
            <div class="flex items-center justify-between pt-3 border-t border-gray-200 mt-auto">
                <span class="inline-block px-2.5 py-1 md:px-3 md:py-1.5 rounded-full text-[11px] md:text-xs font-semibold uppercase tracking-wide" style="background: {{ $bgColor }}20; color: {{ $bgColor }};">
                    {{ ucfirst($categoria['tipo']) }}
                </span>
                <span class="text-gray-600 font-semibold text-sm md:text-base flex items-center gap-2 hover:gap-3 transition-all">
                    Explorar <i class="fas fa-arrow-right text-sm md:text-base"></i>
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

<script>
function filterCategories(tipo) {
    const tipoMap = {
        'Todas': 'todas',
        'Geográficas': 'geografica',
        'Turismo': 'turismo',
        'Cultural': 'cultural',
        'Naturaleza': 'naturaleza',
        'Gastronomía': 'gastronomia'
    };

    const tipoBuscado = tipoMap[tipo] || 'todas';

    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.filter === tipo) {
            btn.classList.remove('bg-white/50', 'text-gray-600', 'hover:bg-white/80');
            btn.classList.add('bg-gradient-to-r', 'from-forest-500', 'to-forest-600', 'text-white', 'shadow-lg');
        } else {
            btn.classList.add('bg-white/50', 'text-gray-600', 'hover:bg-white/80');
            btn.classList.remove('bg-gradient-to-r', 'from-forest-500', 'to-forest-600', 'text-white', 'shadow-lg');
        }
    });

    document.querySelectorAll('.categoria-card').forEach(card => {
        const cardTipo = card.dataset.tipo;
        if (tipo === 'Todas' || cardTipo === tipoBuscado) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

</div>
@endsection
