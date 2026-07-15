@extends('layouts.premium')

@section('title', $item->nombre ?? 'Detalle Iglesia')

@section('content')
<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Hero Section -->
<div class="relative h-[50vh] sm:h-[60vh] md:h-[75vh] min-h-[400px] md:min-h-[600px] overflow-hidden rounded-[32px] mb-12">
    @if($item->imagen)
        <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center">
            <span class="text-6xl md:text-8xl">⛪</span>
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="bg-white/90 backdrop-blur-sm inline-block mb-3 md:mb-6 px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
            ⛪ Iglesia
        </div>
        <h1 class="font-display text-2xl md:text-4xl lg:text-5xl xl:text-7xl font-bold mb-2 md:mb-4 leading-tight" style="text-shadow: 2px 2px 12px rgba(0,0,0,0.8);">
            {{ $item->nombre }}
        </h1>
        <p class="text-sm md:text-lg lg:text-xl opacity-90 max-w-3xl mb-4 md:mb-6" style="text-shadow: 1px 1px 6px rgba(0,0,0,0.6);">
            @if($item->locality_municipio && $item->locality_departamento)
                {{ $item->locality_municipio }}, {{ $item->locality_departamento }}
            @elseif($item->locality_departamento)
                {{ $item->locality_departamento }}
            @elseif($item->locality_municipio)
                {{ $item->locality_municipio }}
            @else
                Ubicación por confirmar
            @endif
            @if($item->locality_region)
                <br>Región: {{ $item->locality_region }}
            @endif
        </p>
    </div>
</div>

<!-- Información Principal -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <div class="lg:col-span-2">
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[32px] shadow-lg mb-8">
            <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 mb-6">Sobre la Iglesia</h2>
            <p class="text-gray-700 text-lg leading-relaxed">
                {{ $item->descripcion ?? 'Sin descripción disponible' }}
            </p>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-[32px] shadow-lg sticky top-8">
            <h2 class="font-display text-2xl font-bold text-gray-900 mb-6">Ubicación</h2>
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-map-marker-alt text-amber-600 text-xl"></i>
                <p class="text-gray-700">
                    @if($item->locality_municipio && $item->locality_departamento)
                        {{ $item->locality_municipio }}, {{ $item->locality_departamento }}
                    @elseif($item->locality_departamento)
                        {{ $item->locality_departamento }}
                    @elseif($item->locality_municipio)
                        {{ $item->locality_municipio }}
                    @else
                        Ubicación por confirmar
                    @endif
                </p>
            </div>
            @if($item->locality_region)
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-compass text-amber-600 text-xl"></i>
                <p class="text-gray-700">Región: {{ $item->locality_region }}</p>
            </div>
            @endif
            <div class="bg-amber-50 p-6 rounded-2xl mb-6">
                <div class="text-center">
                    <i class="fas fa-church text-amber-600 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-600">Patrimonio Religioso</p>
                </div>
            </div>
            <a href="{{ route('puntos-interes.iglesias') }}" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-full font-semibold hover:shadow-lg transition-all">
                ← Volver a Iglesias
            </a>
        </div>
    </div>
</div>

<!-- Iglesias Relacionadas -->
<div class="bg-white/80 backdrop-blur-sm p-12 text-center bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-[32px] shadow-lg">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Cultura</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Descubre otros sitios religiosos y culturales en Colombia</p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('puntos-interes.iglesias') }}" class="px-6 py-3 bg-white text-amber-600 rounded-full font-semibold hover:shadow-lg transition-all">
            ⛪ Todas las Iglesias
        </a>
        <a href="{{ route('puntos-interes.museos') }}" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🏛️ Museos
        </a>
        <a href="/eventos" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🎭 Eventos
        </a>
    </div>
</div>

</div>
@endsection
