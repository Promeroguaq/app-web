@extends('layouts.premium')

@section('title', data_get($item, 'nombre', 'Detalle Desierto/Laguna'))

@section('content')
<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Hero Section -->
<div class="relative h-[50vh] sm:h-[60vh] md:h-[75vh] min-h-[400px] md:min-h-[600px] overflow-hidden rounded-[32px] mb-12">
    @if(data_get($item, 'imagen'))
        <img src="{{ data_get($item, 'imagen') }}" alt="{{ data_get($item, 'nombre', 'Desierto o laguna') }}" class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-amber-600 flex items-center justify-center">
            <span class="text-6xl md:text-8xl">🏜️</span>
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="bg-white/90 backdrop-blur-sm inline-block mb-3 md:mb-6 px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
            🏜️ Desierto/Laguna
        </div>
        <h1 class="font-display text-2xl md:text-4xl lg:text-5xl xl:text-7xl font-bold mb-2 md:mb-4 leading-tight" style="text-shadow: 2px 2px 12px rgba(0,0,0,0.8);">
            {{ data_get($item, 'nombre', 'Desierto o laguna') }}
        </h1>
        <p class="text-sm md:text-lg lg:text-xl opacity-90 max-w-3xl mb-4 md:mb-6" style="text-shadow: 1px 1px 6px rgba(0,0,0,0.6);">
            @if(data_get($item, 'localidad') && data_get($item, 'departamento'))
                {{ data_get($item, 'localidad') }}, {{ data_get($item, 'departamento') }}
            @elseif(data_get($item, 'departamento'))
                {{ data_get($item, 'departamento') }}
            @elseif(data_get($item, 'localidad'))
                {{ data_get($item, 'localidad') }}
            @else
                Ubicación por confirmar
            @endif
            @if(data_get($item, 'region'))
                <br>Región: {{ data_get($item, 'region') }}
            @endif
        </p>
    </div>
</div>

<!-- Información Principal -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <div class="lg:col-span-2">
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[32px] shadow-lg mb-8">
            <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 mb-6">Sobre el Destino</h2>
            <p class="text-gray-700 text-lg leading-relaxed">
                {{ data_get($item, 'descripcion', 'Sin descripción disponible') }}
            </p>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[32px] shadow-lg sticky top-8">
            <h2 class="font-display text-2xl font-bold text-gray-900 mb-6">Ubicación</h2>
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-map-marker-alt text-yellow-600 text-xl"></i>
                <p class="text-gray-700">
                    @if(data_get($item, 'localidad') && data_get($item, 'departamento'))
                        {{ data_get($item, 'localidad') }}, {{ data_get($item, 'departamento') }}
                    @elseif(data_get($item, 'departamento'))
                        {{ data_get($item, 'departamento') }}
                    @elseif(data_get($item, 'localidad'))
                        {{ data_get($item, 'localidad') }}
                    @else
                        Ubicación por confirmar
                    @endif
                </p>
            </div>
            @if(data_get($item, 'region'))
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-compass text-yellow-600 text-xl"></i>
                <p class="text-gray-700">Región: {{ data_get($item, 'region') }}</p>
            </div>
            @endif
            <div class="bg-yellow-50 p-6 rounded-2xl mb-6">
                <div class="text-center">
                    <i class="fas fa-sun text-yellow-600 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-600">Paisaje Único</p>
                </div>
            </div>
            <a href="{{ route('puntos-interes.desiertos-lagunas') }}" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-amber-600 text-white rounded-full font-semibold hover:shadow-lg transition-all">
                ← Volver a Desiertos y Lagunas
            </a>
        </div>
    </div>
</div>

<!-- Destinos Relacionados -->
<div class="bg-white/80 backdrop-blur-sm p-12 text-center bg-gradient-to-r from-yellow-500 to-amber-600 text-white rounded-[32px] shadow-lg">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Naturaleza</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Descubre otros paisajes únicos en Colombia</p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('puntos-interes.desiertos-lagunas') }}" class="px-6 py-3 bg-white text-yellow-600 rounded-full font-semibold hover:shadow-lg transition-all">
            🏜️ Todos los Desiertos y Lagunas
        </a>
        <a href="{{ route('puntos-interes.reservas-naturales') }}" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🌲 Reservas Naturales
        </a>
        <a href="/puntos-interes/islas" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🏝️ Islas
        </a>
    </div>
</div>

</div>
@endsection
