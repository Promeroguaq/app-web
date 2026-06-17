@extends('layouts.premium')

@section('title', 'Rutas Turísticas')

@section('content')
<!-- Hero Premium -->
<div class="relative h-[420px] md:h-[480px] rounded-[32px] overflow-hidden mb-12 md:mb-16 max-w-7xl mx-auto" style="background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #6d28d9 100%);">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🌿 Explora Colombia
        </div>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
            Rutas turísticas por Colombia
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl">
            Explora caminos, senderos y recorridos que conectan naturaleza, cultura y aventura.
        </p>
        <div class="flex flex-wrap gap-3 mt-6">
            <span class="glass-badge text-sm">Senderismo</span>
            <span class="glass-badge text-sm">Naturaleza</span>
            <span class="glass-badge text-sm">Cultura</span>
            <span class="glass-badge text-sm">Aventura</span>
            <span class="glass-badge text-sm">Rutas guiadas</span>
        </div>
        <div class="flex gap-4 mt-8">
            <button onclick="document.getElementById('rutas-destacadas').scrollIntoView({behavior: 'smooth'})" class="px-6 py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all">
                Explorar rutas
            </button>
            <button onclick="document.getElementById('mapa-section').scrollIntoView({behavior: 'smooth'})" class="px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                Ver mapa
            </button>
        </div>
    </div>
</div>

<!-- Filtros Premium -->
<div class="bg-white/80 backdrop-blur-sm rounded-[24px] p-6 md:p-8 mb-12 md:mb-16 max-w-7xl mx-auto shadow-sm">
    <div class="flex flex-wrap gap-3 justify-center">
        <button class="px-5 py-2.5 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold text-sm shadow-md hover:shadow-lg transition-all">
            Todas
        </button>
        <button class="px-5 py-2.5 bg-white text-gray-600 rounded-full font-semibold text-sm border-2 border-gray-200 hover:border-[#1D4ED8] hover:text-[#1D4ED8] transition-all">
            🟢 Fácil
        </button>
        <button class="px-5 py-2.5 bg-white text-gray-600 rounded-full font-semibold text-sm border-2 border-gray-200 hover:border-amber-500 hover:text-amber-500 transition-all">
            🟡 Moderada
        </button>
        <button class="px-5 py-2.5 bg-white text-gray-600 rounded-full font-semibold text-sm border-2 border-gray-200 hover:border-red-500 hover:text-red-500 transition-all">
            🔴 Difícil
        </button>
    </div>
</div>

<!-- Rutas Destacadas -->
<div id="rutas-destacadas" class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Rutas Destacadas</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($rutas as $ruta)
        <div class="rounded-[28px] overflow-hidden bg-white shadow-[0_10px_35px_rgba(0,0,0,0.10)] hover:-translate-y-2 hover:scale-[1.01] transition-all duration-500 cursor-pointer group">
            <div class="relative h-56 overflow-hidden @if(isset($ruta['imagen']) && $ruta['imagen']) @else bg-gradient-to-br from-purple-600 to-indigo-700 @endif">
                @if(isset($ruta['imagen']) && $ruta['imagen'])
                <img src="{{ $ruta['imagen'] }}" alt="{{ $ruta['nombre'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                @if($ruta['dificultad'] === 'Fácil')
                <div class="absolute top-4 left-4 bg-[#1D4ED8]/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs text-white font-semibold">
                    🟢 Fácil
                </div>
                @elseif($ruta['dificultad'] === 'Moderada')
                <div class="absolute top-4 left-4 bg-amber-500/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs text-white font-semibold">
                    🟡 Moderada
                </div>
                @else
                <div class="absolute top-4 left-4 bg-red-500/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs text-white font-semibold">
                    🔴 Difícil
                </div>
                @endif
                <div class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs text-white font-semibold">
                    ${{ number_format($ruta['precio'], 0, ',', '.') }}
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                    <div class="flex gap-4 text-sm font-medium">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-route"></i> {{ $ruta['distancia'] }} km
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-clock"></i> {{ $ruta['duracion'] }} días
                        </span>
                    </div>
                </div>
            </div>
            <div class="p-5 md:p-6">
                <h3 class="font-display text-lg md:text-xl font-bold text-gray-900 mb-2">{{ $ruta['nombre'] }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $ruta['descripcion'] }}</p>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                    <span>{{ $ruta['punto_inicio'] }} → {{ $ruta['punto_fin'] }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-map text-[#1D4ED8]"></i>
                    <span>{{ $ruta['departamento'] }}</span>
                </div>
                <button class="w-full mt-4 px-4 py-2.5 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all text-sm">
                    Ver ruta
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Consejos para el Viajero -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Consejos para preparar tu ruta</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">💧</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Hidratación</h3>
            <p class="text-gray-600 text-sm">Lleva suficiente agua y protección solar durante todo el recorrido.</p>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">🌤️</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Clima</h3>
            <p class="text-gray-600 text-sm">Consulta el clima antes de salir y prepárate para condiciones variables.</p>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">🥾</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Senderos</h3>
            <p class="text-gray-600 text-sm">Respeta los senderos marcados y no te alejes de las rutas establecidas.</p>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">🧭</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Guías</h3>
            <p class="text-gray-600 text-sm">Viaja con guía local en rutas de alta dificultad para mayor seguridad.</p>
        </div>
    </div>
</div>

<!-- Mapa Section -->
<div id="mapa-section" class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Mapa de Rutas</h2>
    <div class="rounded-[32px] overflow-hidden bg-gradient-to-br from-[#F7F3EA] to-[#f0ebe3] h-[400px] flex items-center justify-center">
        <div class="text-center">
            <i class="fas fa-map-marked-alt text-6xl text-[#1D4ED8] mb-4"></i>
            <p class="text-gray-600 text-lg">Mapa interactivo de rutas turísticas</p>
            <p class="text-gray-500 text-sm mt-2">Próximamente disponible</p>
        </div>
    </div>
</div>

<!-- CTA Final -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] rounded-[32px] p-8 md:p-12 text-center text-white">
        <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">¿Listo para tu próxima aventura?</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Descubre rutas únicas que te conectarán con la naturaleza, cultura y gente de Colombia.</p>
        <button class="px-8 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            Planear mi ruta
        </button>
    </div>
</div>
@endsection
