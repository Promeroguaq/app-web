@extends('layouts.premium')

@section('title', 'Municipios')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section -->
<div class="relative h-[40vh] sm:h-[50vh] md:h-[60vh] lg:h-[75vh] min-h-[300px] md:min-h-[400px] lg:min-h-[600px] overflow-hidden rounded-[32px] mb-6 md:mb-8 w-full" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);">
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="bg-white/90 backdrop-blur-sm inline-block mb-2 md:mb-6 px-2 py-1 md:px-4 md:py-2 rounded-full text-[10px] md:text-sm font-semibold text-gray-800 shadow-md z-10">
            🏛️ 1,100+ Municipios
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-7xl font-bold mb-2 md:mb-4 leading-tight" style="text-shadow: 2px 2px 12px rgba(0,0,0,0.8);">
            Municipios de Colombia
        </h1>
        <p class="text-xs md:text-sm lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-3xl mb-3 md:mb-6" style="text-shadow: 1px 1px 6px rgba(0,0,0,0.6);">
            Explora los municipios de todo el país
        </p>
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[32px] shadow-lg">
    <!-- Botón toggle filtros en móvil -->
    <button id="toggle-filters" class="md:hidden w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs mb-4">
        <i class="fas fa-filter"></i>
        <span>Filtros</span>
        <i class="fas fa-chevron-down transition-transform" id="filter-icon"></i>
    </button>
    
    <!-- Contenedor de filtros -->
    <div id="filters-container" class="hidden md:block">
        <form action="{{ route('municipios.index') }}" method="GET" id="filter-form">
            <!-- Búsqueda principal -->
            <div class="mb-4 md:mb-6">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs md:text-sm"></i>
                    <input type="text" 
                           id="search-input"
                           name="search" 
                           value="{{ $search ?? '' }}" 
                           placeholder="Buscar por nombre, departamento o región..." 
                           class="w-full pl-9 md:pl-12 pr-3 md:pr-4 py-2 md:py-3 border-2 border-gray-200 rounded-full text-xs md:text-sm focus:border-forest-500 focus:outline-none transition-all">
                </div>
            </div>
            
            <!-- Filtros adicionales -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4 mb-4 md:mb-6">
                <!-- Filtro por departamento -->
                <div class="relative">
                    <label class="block text-[10px] md:text-xs font-semibold text-gray-600 mb-1 md:mb-2">Departamento</label>
                    <select name="departamento" 
                            id="departamento-select"
                            class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-200 rounded-full text-xs md:text-sm focus:border-forest-500 focus:outline-none transition-all appearance-none bg-white">
                        <option value="">Todos los departamentos</option>
                        @foreach($departamentos ?? collect([]) as $depto)
                        <option value="{{ $depto['slug'] }}" {{ $departamento == $depto['slug'] ? 'selected' : '' }}>
                            {{ $depto['name'] }}
                        </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 md:right-4 top-[50%] md:top-[60%] -translate-y-1/2 text-gray-400 text-xs md:text-sm pointer-events-none"></i>
                </div>
                
                <!-- Botones de acción -->
                <div class="flex items-end gap-2 md:gap-3">
                    <button type="submit" class="flex-1 px-3 py-2 md:px-6 md:py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all text-xs md:text-sm">
                        <i class="fas fa-search mr-1 md:mr-2"></i> Buscar
                    </button>
                    @if($search || $departamento)
                    <a href="{{ route('municipios.index') }}" class="px-3 py-2 md:px-6 md:py-3 bg-gray-500 text-white rounded-full font-semibold hover:bg-gray-600 transition-all text-xs md:text-sm whitespace-nowrap">
                        <i class="fas fa-times mr-1"></i> Limpiar
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Contador de resultados -->
<div class="flex items-center justify-between mb-4 md:mb-6">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900">
        @if($search || $departamento)
        Resultados encontrados
        @else
        Municipios
        @endif
    </h2>
    <div class="text-[10px] md:text-sm text-gray-600" data-total="{{ $total ?? 0 }}">
        Mostrando {{ $items->count() }} de {{ $total ?? 0 }} municipios
    </div>
</div>

<!-- Grid de Municipios -->
<div id="municipios-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    @forelse($items as $item)
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="{{ route('municipios.show', $item->id) }}" class="block">
            <div class="relative h-40 sm:h-48 md:h-56 overflow-hidden w-full">
                @if($item->imagen)
                <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                @else
                <div class="w-full h-full bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] flex items-center justify-center">
                    <i class="fas fa-city text-white text-4xl md:text-5xl lg:text-6xl"></i>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-full text-[10px] md:text-xs font-semibold text-gray-800 shadow-md z-10">
                    <i class="fas fa-city mr-1 text-[10px] md:text-xs"></i> Municipio
                </div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    @if($item->departamento_nombre)
                    <div class="flex items-center gap-2 text-[10px] md:text-sm">
                        <i class="fas fa-map text-[10px] md:text-sm"></i> {{ $item->departamento_nombre }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="p-3 md:p-5 bg-white">
                <h3 class="font-display text-sm md:text-base lg:text-lg xl:text-xl font-bold text-gray-900 mb-2">{{ $item->nombre }}</h3>
                <p class="text-[10px] md:text-xs lg:text-sm text-gray-600 mb-2 md:mb-3 line-clamp-2">{{ Str::limit($item->descripcion, 100) ?? 'Municipio de Colombia' }}</p>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <div class="flex items-center gap-2 text-[10px] md:text-xs lg:text-sm text-gray-500">
                        <i class="fas fa-map-marker-alt text-[#1D4ED8] text-[10px] md:text-xs lg:text-sm"></i>
                        <span>{{ $item->departamento_nombre ?? 'Colombia' }}</span>
                    </div>
                    <span class="text-[#1D4ED8] font-semibold text-[10px] md:text-xs lg:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Ver más <i class="fas fa-arrow-right text-[10px] md:text-xs lg:text-sm"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-span-full bg-white/80 backdrop-blur-sm p-6 md:p-8 lg:p-12 text-center text-gray-500 rounded-[20px] md:rounded-[32px] shadow-lg">
        <i class="fas fa-city text-3xl md:text-4xl mb-3 md:mb-4 opacity-50"></i>
        <p class="text-xs md:text-sm lg:text-base lg:text-lg">
            @if($search || $departamento)
            No encontramos municipios con esos filtros. Intenta buscar por nombre o departamento.
            @else
            No hay municipios registrados en este momento.
            @endif
        </p>
        @if($search || $departamento)
        <a href="{{ route('municipios.index') }}" class="inline-block mt-4 px-4 py-2 md:px-6 md:py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs md:text-sm hover:shadow-lg transition-all">
            <i class="fas fa-times mr-2"></i> Limpiar filtros
        </a>
        @endif
    </div>
    @endforelse
</div>

<!-- Botón Cargar más -->
@if($hasMore ?? false)
<div class="text-center mb-6 md:mb-8">
    <button id="load-more" 
            data-page="{{ $page ?? 1 }}"
            data-per-page="{{ $perPage ?? 12 }}"
            data-search="{{ $search ?? '' }}"
            data-departamento="{{ $departamento ?? '' }}"
            data-region="{{ $region ?? '' }}"
            class="px-6 py-3 md:px-8 md:py-4 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-xs md:text-sm hover:shadow-lg transition-all">
        <i class="fas fa-plus mr-2"></i> Cargar más municipios
    </button>
</div>
@endif

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>

<script>
// Toggle filtros en móvil
document.getElementById('toggle-filters').addEventListener('click', function() {
    const container = document.getElementById('filters-container');
    const icon = document.getElementById('filter-icon');
    
    container.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
});

// Helper de normalización de texto
function normalizeText(text) {
    if (!text) return '';
    return text
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();
}

// Búsqueda en tiempo real con debounce
let searchTimeout;
document.getElementById('search-input').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const form = document.getElementById('filter-form');
        form.submit();
    }, 500);
});

// Cargar más municipios
document.getElementById('load-more')?.addEventListener('click', function() {
    const button = this;
    const currentPage = parseInt(button.dataset.page);
    const perPage = parseInt(button.dataset.perPage);
    const search = button.dataset.search;
    const departamento = button.dataset.departamento;
    const region = button.dataset.region;
    
    // Construir URL con parámetros
    const params = new URLSearchParams();
    params.set('page', currentPage + 1);
    params.set('per_page', perPage);
    if (search) params.set('search', search);
    if (departamento) params.set('departamento', departamento);
    if (region) params.set('region', region);
    
    // Mostrar loading
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Cargando...';
    button.disabled = true;
    
    // Fetch más municipios
    fetch(`{{ route('municipios.index') }}?${params.toString()}`)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newItems = doc.querySelectorAll('#municipios-grid > div');
            const grid = document.getElementById('municipios-grid');
            
            newItems.forEach(item => {
                grid.appendChild(item.cloneNode(true));
            });
            
            // Actualizar botón
            const newHasMore = doc.querySelector('#load-more')?.dataset.hasMore === 'true';
            if (newHasMore) {
                button.dataset.page = currentPage + 1;
                button.innerHTML = '<i class="fas fa-plus mr-2"></i> Cargar más municipios';
                button.disabled = false;
            } else {
                button.remove();
            }
            
            // Actualizar contador
            const newTotal = parseInt(doc.querySelector('[data-total]')?.dataset.total || 0);
            const currentCount = grid.children.length;
            document.querySelector('.text-gray-600').textContent = `Mostrando ${currentCount} de ${newTotal} municipios`;
        })
        .catch(error => {
            console.error('Error al cargar más municipios:', error);
            button.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> Error. Intenta de nuevo';
            button.disabled = false;
        });
});
</script>
@endsection
