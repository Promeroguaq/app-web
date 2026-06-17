@extends('layouts.premium')

@section('title', $route->nombre ?? 'Detalle de Ruta de Ciclismo')

@section('content')
<!-- Hero Premium de Ruta -->
<div class="relative h-[420px] md:h-[480px] rounded-[32px] overflow-hidden mb-12 md:mb-16 max-w-7xl mx-auto">
    <img src="{{ $route->imagen }}" alt="{{ $route->nombre }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-4">
            🚴 Ciclismo
        </div>
        <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-3 leading-tight">
            {{ $route->nombre }}
        </h1>
        <div class="flex items-center gap-2 text-sm md:text-base opacity-90">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ $route->localidad ?? 'Colombia' }}</span>
        </div>
    </div>
</div>

<!-- Stats Visuales -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-road"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Ruta</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-mountain"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Aventura</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-clock"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Tiempo</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Distancia</div>
        </div>
    </div>
</div>

<!-- Descripción -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="bg-white rounded-[28px] p-8 md:p-12 shadow-sm">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6">Sobre esta ruta</h2>
        <p class="text-gray-600 text-base leading-relaxed">
            {{ $route->descripcion ?? 'Descripción no disponible.' }}
        </p>
    </div>
</div>

<!-- Información Práctica -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-8">Información Práctica</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-[#f8f5f0] rounded-[24px] p-6">
            <div class="flex items-start gap-4">
                <div class="text-3xl">📍</div>
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Ubicación</h3>
                    <p class="text-gray-600 text-sm">{{ $route->localidad ?? 'Colombia' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6">
            <div class="flex items-start gap-4">
                <div class="text-3xl">⏱️</div>
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Duración</h3>
                    <p class="text-gray-600 text-sm">Variable según el ritmo</p>
                </div>
            </div>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6">
            <div class="flex items-start gap-4">
                <div class="text-3xl">🎯</div>
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Nivel</h3>
                    <p class="text-gray-600 text-sm">Intermedio - Avanzado</p>
                </div>
            </div>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6">
            <div class="flex items-start gap-4">
                <div class="text-3xl">🛣️</div>
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Terreno</h3>
                    <p class="text-gray-600 text-sm">Mixto (asfalto y trocha)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recomendaciones -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-8">Recomendaciones</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">🪖</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Casco</h3>
                <p class="text-gray-600 text-sm">Usa siempre casco certificado</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">💧</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Hidratación</h3>
                <p class="text-gray-600 text-sm">Lleva suficiente agua e isotónicos</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">🔧</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Mantenimiento</h3>
                <p class="text-gray-600 text-sm">Revisa frenos, cadena y presión</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">🌤️</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Clima</h3>
                <p class="text-gray-600 text-sm">Consulta el clima antes de salir</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">☀️</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Protector solar</h3>
                <p class="text-gray-600 text-sm">Usa bloqueador solar y gafas</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">📱</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Comunicación</h3>
                <p class="text-gray-600 text-sm">Lleva teléfono con batería</p>
            </div>
        </div>
    </div>
</div>

<!-- Mapa y Google Maps -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-8">Mapa de la Ruta</h2>
    <div class="bg-gradient-to-br from-[#F7F3EA] to-[#f0ebe3] rounded-[32px] p-8 md:p-12 text-center">
        <i class="fas fa-map-marked-alt text-6xl text-[#1D4ED8] mb-4"></i>
        <p class="text-gray-600 text-lg mb-6">Explora esta ruta en Google Maps</p>
        <a href="https://www.google.com/maps/search/{{ urlencode('ciclismo ' . $route->nombre . ' ' . ($route->localidad ?? 'Colombia')) }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all">
            <i class="fas fa-map-marked-alt"></i>
            Abrir en Google Maps
        </a>
    </div>
</div>

<!-- CTA Final -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] rounded-[32px] p-8 md:p-12 text-center text-white">
        <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">¿Listo para esta aventura?</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Prepara tu bicicleta, revisa el clima y disfruta de esta increíble ruta de ciclismo por Colombia.</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('puntos-interes.ciclismo') }}" class="px-8 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
                Ver más rutas
            </a>
            <a href="https://www.google.com/maps/search/{{ urlencode('ciclismo ' . $route->nombre . ' ' . ($route->localidad ?? 'Colombia')) }}" target="_blank" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                <i class="fas fa-map-marked-alt mr-2"></i>
                Google Maps
            </a>
        </div>
    </div>
</div>
@endsection
