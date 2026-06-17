@extends('layouts.premium')

@section('title', 'Categorías Turísticas')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Immersive -->
<div class="relative h-[40vh] sm:h-[50vh] md:h-[60vh] lg:h-[75vh] min-h-[300px] md:min-h-[400px] lg:min-h-[600px] overflow-hidden rounded-[32px] mb-8 md:mb-12 w-full" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);">
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="bg-white/90 backdrop-blur-sm inline-block mb-3 md:mb-6 px-2 py-1 md:px-4 md:py-2 rounded-full text-[10px] md:text-sm font-semibold text-gray-800 shadow-md z-10">
            🌍 Explora Colombia
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-7xl font-bold mb-2 md:mb-4 leading-tight" style="text-shadow: 2px 2px 12px rgba(0,0,0,0.8);">
            Categorías Turísticas
        </h1>
        <p class="text-xs md:text-sm lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-3xl mb-4 md:mb-6" style="text-shadow: 1px 1px 6px rgba(0,0,0,0.6);">
            Descubre todos los destinos, experiencias y maravillas de Colombia
        </p>
    </div>
</div>

<!-- Premium Filters -->
<div class="bg-white/80 backdrop-blur-sm p-3 md:p-4 lg:p-6 mb-8 md:mb-12 rounded-[20px] md:rounded-[32px] shadow-lg">
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
    
    <div class="categoria-card rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full" data-tipo="{{ $categoria['tipo'] }}" onclick="window.location.href='{{ $categoria['ruta'] }}'">
        <div class="relative h-40 sm:h-44 md:h-48 overflow-hidden w-full" style="background: {{ $categoriaGradient }};">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                {{ $categoria['nombre'] }}
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-3 md:p-4 text-white z-10">
                <div class="text-xl md:text-2xl font-bold font-display">{{ $categoria['count'] }}</div>
                <div class="text-[10px] md:text-xs opacity-90">Registros</div>
            </div>
        </div>
        <div class="p-4 md:p-6 bg-white">
            <h3 class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold text-gray-900 mb-2">{{ $categoria['nombre'] }}</h3>
            <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">{{ $categoria['descripcion'] }}</p>
            <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                <span class="inline-block px-2 py-1 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-semibold" style="background: {{ $bgColor }}20; color: {{ $bgColor }};">
                    {{ ucfirst($categoria['tipo']) }}
                </span>
                <span class="text-gray-600 font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                    Ver más <i class="fas fa-arrow-right text-xs md:text-sm"></i>
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
