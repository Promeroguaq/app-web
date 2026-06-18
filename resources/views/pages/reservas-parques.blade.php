@extends('layouts.premium')

@section('title', 'Reservas y Parques Naturales')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section - Nature Style -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🌿 Naturaleza Protegida
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Reservas y Parques Naturales
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Explora áreas protegidas, jardines botánicos, parques naturales y reservas ecológicas de Colombia
        </p>
    </div>
</div>

<!-- Premium Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $total ?? 0 }}</div>
        <div class="text-sm text-gray-600 font-medium">Reservas y Parques</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $regiones->count() }}</div>
        <div class="text-sm text-gray-600 font-medium">Regiones</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $localidades->count() }}</div>
        <div class="text-sm text-gray-600 font-medium">Localidades</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">100%</div>
        <div class="text-sm text-gray-600 font-medium">Natural</div>
    </div>
</div>

<!-- Search and Filters -->
<div class="glass-card p-6 mb-12 rounded-[32px]">
    <form method="GET" action="{{ route('reservas-parques.index') }}" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <input type="text" name="buscar" placeholder="Buscar reserva o parque..." value="{{ request('buscar') }}" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all">
        </div>
        <!-- Region Filter -->
        <div class="md:w-48">
            <select name="region" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all">
                <option value="">Todas las regiones</option>
                @foreach($regiones as $region)
                    <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>Región {{ $region }}</option>
                @endforeach
            </select>
        </div>
        <!-- Locality Filter -->
        <div class="md:w-48">
            <select name="locality" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all">
                <option value="">Todas las localidades</option>
                @foreach($localidades as $locality)
                    <option value="{{ $locality }}" {{ request('locality') == $locality ? 'selected' : '' }}>Localidad {{ $locality }}</option>
                @endforeach
            </select>
        </div>
        <!-- Submit Button -->
        <div class="md:w-auto">
            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-full font-semibold hover:shadow-lg transition-all">
                <i class="fas fa-search mr-2"></i>Buscar
            </button>
        </div>
        <!-- Clear Filters -->
        @if(request('buscar') || request('region') || request('locality'))
        <div class="md:w-auto">
            <a href="{{ route('reservas-parques.index') }}" class="w-full md:w-auto px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transition-all inline-block text-center">
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

<!-- Reserves and Parks Cards -->
<div id="reservasGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">

    @forelse($reservas as $reserva)
    <a href="{{ route('reservas-parques.show', ['id' => $reserva->id]) }}" class="cinematic-card group cursor-pointer bg-white block rounded-[28px] overflow-hidden shadow-[0_8px_25px_rgba(0,0,0,0.08)] hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300">
        <!-- Image -->
        <div class="relative h-56 overflow-hidden">
            @if($reserva->imagen ?? null)
                <img src="{{ $reserva->imagen }}" alt="{{ $reserva->nombre ?? 'Reserva' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <div class="w-full h-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                    <span class="text-7xl">🌿</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

            <!-- Badge -->
            <div class="absolute top-4 left-4 glass-badge bg-green-500/30 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs text-white font-semibold">
                @if($reserva->region)
                    {{ $reserva->region }}
                @else
                    Reserva Natural
                @endif
            </div>
        </div>

        <!-- Content -->
        <div class="p-5 md:p-6">
            <h3 class="font-display text-lg md:text-xl font-bold text-gray-900 mb-2">
                {{ $reserva->nombre ?? 'Reserva Natural' }}
            </h3>
            <p class="text-gray-600 mb-4 line-clamp-3 text-sm">
                {{ Str::limit($reserva->descripcion ?? 'Sin descripción', 120) }}
            </p>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                <i class="fas fa-map-marker-alt text-green-500"></i>
                @if($reserva->localidad)
                    {{ $reserva->localidad }}
                @elseif($reserva->region)
                    {{ $reserva->region }}
                @else
                    Ubicación por confirmar
                @endif
            </div>
            <div class="block w-full px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-full font-semibold hover:shadow-lg transition-all text-sm text-center">
                Ver detalle
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full glass-card p-12 text-center text-gray-500 rounded-[28px]">
        <i class="fas fa-tree text-4xl mb-4 opacity-50"></i>
        <p class="text-lg">No hay reservas o parques registrados en este momento.</p>
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
    if(request('buscar')) $queryParams['buscar'] = request('buscar');
    if(request('region')) $queryParams['region'] = request('region');
    if(request('locality')) $queryParams['locality'] = request('locality');
@endphp
<div class="flex justify-center items-center gap-2 mb-12">
    @if($page > 1)
        <a href="?page={{ $page - 1 }}{{ http_build_query($queryParams, '', '&', PHP_QUERY_RFC3986) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">
            <i class="fas fa-chevron-left"></i>
        </a>
    @endif

    @for($i = $startPage; $i <= $endPage; $i++)
        @if($i == $page)
            <span class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-full font-semibold">{{ $i }}</span>
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
