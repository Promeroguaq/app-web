@extends('layouts.premium')

@section('title', 'Gastronomía')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section - Food Photography Style -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🍽️ Sabores de Colombia
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Gastronomía
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Descubre los sabores únicos, tradiciones culinarias y delicias de nuestra tierra
        </p>
    </div>
</div>

<!-- Premium Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-orange-600 mb-2">{{ $totalPlatos ?? 0 }}</div>
        <div class="text-sm text-gray-600 font-medium">Platos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-orange-600 mb-2">{{ $totalDepartamentos ?? 0 }}</div>
        <div class="text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-orange-600 mb-2">{{ $totalCategorias ?? 0 }}</div>
        <div class="text-sm text-gray-600 font-medium">Categorías</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-orange-600 mb-2">100%</div>
        <div class="text-sm text-gray-600 font-medium">Auténtico</div>
    </div>
</div>

<!-- Search and Filters -->
<div class="glass-card p-6 mb-12 rounded-[32px]">
    <form method="GET" action="{{ route('gastronomia') }}" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <input type="text" name="buscar" placeholder="Buscar plato, departamento o categoría..." value="{{ request('buscar') }}" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all">
        </div>
        <!-- Department Filter -->
        <div class="md:w-48">
            <select name="departamento" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all">
                <option value="">Todos los departamentos</option>
                @foreach($departamentos as $depto)
                    <option value="{{ $depto }}" {{ request('departamento') == $depto ? 'selected' : '' }}>{{ $depto }}</option>
                @endforeach
            </select>
        </div>
        <!-- Category Filter -->
        <div class="md:w-48">
            <select name="categoria" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 outline-none transition-all">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <!-- Submit Button -->
        <div class="md:w-auto">
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full font-semibold hover:shadow-lg transition-all">
                <i class="fas fa-search mr-2"></i>Buscar
            </button>
        </div>
        <!-- Clear Filters -->
        @if(request('buscar') || request('departamento') || request('categoria'))
        <div class="md:w-auto">
            <a href="{{ route('gastronomia') }}" class="w-full md:w-auto px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition-all inline-block text-center">
                <i class="fas fa-times mr-2"></i>Limpiar
            </a>
        </div>
        @endif
    </form>
</div>

@if(isset($error))
<div class="glass-card p-8 mb-8 text-center text-red-600 rounded-[32px]">
    <strong>Error:</strong> {{ $error }}
</div>
@endif

<!-- Food Photography Cards -->
<div id="platosGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

    @forelse($platos as $plato)
    <a href="{{ route('gastronomia.show', [$plato->department_slug, $plato->slug]) }}" class="cinematic-card group cursor-pointer bg-white block">
        <!-- Food Image -->
        <div class="relative h-72 overflow-hidden">
            @if($plato->imagen ?? null)
                <img src="{{ $plato->imagen }}" alt="{{ $plato->nombre ?? 'Plato' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <div class="w-full h-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center">
                    <span class="text-7xl">🍽️</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

            <!-- Badge -->
            <div class="absolute top-4 left-4 glass-badge bg-orange-500/30">
                {{ $plato->categoria ?? 'Plato Típico' }}
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-3">
                {{ $plato->nombre ?? 'Plato Típico' }}
            </h3>
            <p class="text-gray-600 mb-4 line-clamp-2 text-sm">
                {{ Str::limit($plato->descripcion ?? 'Sin descripción', 100) }}
            </p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-orange-500"></i>
                <span>{{ $plato->departamento }}</span>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full glass-card p-12 text-center text-gray-500">
        <i class="fas fa-utensils text-4xl mb-4 opacity-50"></i>
        @if($search || $filterDepartment || $filterCategory)
            <p class="text-lg">No encontramos platos que coincidan con los filtros seleccionados.</p>
            <a href="{{ route('gastronomia') }}" class="inline-block mt-4 px-6 py-3 bg-orange-500 text-white rounded-full font-semibold hover:bg-orange-600 transition-all">
                <i class="fas fa-times mr-2"></i>Limpiar filtros
            </a>
        @else
            <p class="text-lg">No hay platos gastronómicos registrados en este momento.</p>
        @endif
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($total > $perPage)
@php
    $totalPages = ceil($total / $perPage);
    $startPage = max(1, $page - 2);
    $endPage = min($totalPages, $page + 2);
    $queryParams = [];
    if(request('departamento')) $queryParams['departamento'] = request('departamento');
    if(request('categoria')) $queryParams['categoria'] = request('categoria');
    if(request('buscar')) $queryParams['buscar'] = request('buscar');
@endphp
<div class="flex justify-center items-center gap-2 mb-12">
    @if($page > 1)
        <a href="?page={{ $page - 1 }}{{ http_build_query($queryParams, '', '&', PHP_QUERY_RFC3986) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">
            <i class="fas fa-chevron-left"></i>
        </a>
    @endif

    @for($i = $startPage; $i <= $endPage; $i++)
        @if($i == $page)
            <span class="px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full font-semibold">{{ $i }}</span>
        @else
            <a href="?page={{ $i }}{{ http_build_query($queryParams, '', '&', PHP_QUERY_RFC3986) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">{{ $i }}</a>
        @endif
    @endfor

    @if($page < $totalPages)
        <a href="?page={{ $page + 1 }}{{ http_build_query($queryParams, '', '&', PHP_QUERY_RFC3986) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">
            <i class="fas fa-chevron-right"></i>
        </a>
    @endif
</div>
@endif

</div>
@endsection
