@extends('layouts.premium')

@section('title', $item->nombre ?? 'Detalle de Deporte de Aventura')

@section('content')
<!-- Hero Premium de Deporte -->
<div class="relative h-[420px] md:h-[480px] rounded-[32px] overflow-hidden mb-12 md:mb-16 max-w-7xl mx-auto">
    @if($item->imagen)
        <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full bg-gradient-to-br from-[#ea580c] to-[#c2410c] flex items-center justify-center">
            <i class="fas fa-mountain text-white text-8xl opacity-50"></i>
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-4">
            🧗 Aventura
        </div>
        <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-3 leading-tight">
            {{ $item->nombre }}
        </h1>
        <div class="flex items-center gap-2 text-sm md:text-base opacity-90">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ $item->localidad ?? 'Colombia' }}</span>
        </div>
    </div>
</div>

<!-- Stats Visuales -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-bolt"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Adrenalina</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Seguro</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-clock"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Tiempo</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">
                <i class="fas fa-star"></i>
            </div>
            <div class="text-sm text-gray-600 font-medium">Nivel</div>
        </div>
    </div>
</div>

<!-- Descripción -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="bg-white rounded-[28px] p-8 md:p-12 shadow-sm">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6">Sobre esta actividad</h2>
        <p class="text-gray-600 text-base leading-relaxed">
            {{ $item->descripcion ?? 'Descripción no disponible.' }}
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
                    <p class="text-gray-600 text-sm">{{ $item->localidad ?? 'Colombia' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6">
            <div class="flex items-start gap-4">
                <div class="text-3xl">⏱️</div>
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Duración</h3>
                    <p class="text-gray-600 text-sm">Variable según la actividad</p>
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
                <div class="text-3xl">👥</div>
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Guía</h3>
                    <p class="text-gray-600 text-sm">Recomendado para seguridad</p>
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
                <h3 class="font-semibold text-gray-900 mb-1">Equipo de seguridad</h3>
                <p class="text-gray-600 text-sm">Usa siempre el equipo de seguridad adecuado</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">💧</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Hidratación</h3>
                <p class="text-gray-600 text-sm">Lleva suficiente agua y bebidas isotónicas</p>
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
            <span class="text-2xl">👟</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Calzado apropiado</h3>
                <p class="text-gray-600 text-sm">Usa calzado deportivo o especializado</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">📱</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Comunicación</h3>
                <p class="text-gray-600 text-sm">Lleva teléfono con batería</p>
            </div>
        </div>
        <div class="flex items-start gap-3 bg-white rounded-[20px] p-5 shadow-sm">
            <span class="text-2xl">🏥</span>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Seguro</h3>
                <p class="text-gray-600 text-sm">Verifica tu seguro de viaje</p>
            </div>
        </div>
    </div>
</div>

<!-- Mapa y Google Maps -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-8">Ubicación</h2>
    <div class="bg-gradient-to-br from-[#F7F3EA] to-[#f0ebe3] rounded-[32px] p-8 md:p-12 text-center">
        <i class="fas fa-map-marked-alt text-6xl text-[#1D4ED8] mb-4"></i>
        <p class="text-gray-600 text-lg mb-6">Explora dónde practicar esta actividad en Google Maps</p>
        <a href="https://www.google.com/maps/search/{{ urlencode($item->nombre . ' ' . ($item->localidad ?? 'Colombia')) }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all">
            <i class="fas fa-map-marked-alt"></i>
            Abrir en Google Maps
        </a>
    </div>
</div>

<!-- Actividades Relacionadas -->
@if(isset($relacionados) && $relacionados->count() > 0)
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-8">Actividades Relacionadas</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($relacionados as $rel)
        <div class="rounded-[24px] overflow-hidden bg-white shadow-[0_8px_25px_rgba(0,0,0,0.08)] hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300 cursor-pointer group">
            <div class="relative h-40 overflow-hidden">
                @if($rel->imagen)
                    <img src="{{ $rel->imagen }}" alt="{{ $rel->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] flex items-center justify-center">
                        <i class="fas fa-mountain text-white text-4xl"></i>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                    <h3 class="font-semibold text-sm">{{ $rel->nombre }}</h3>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                    <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                    <span>{{ $rel->localidad ?? 'Colombia' }}</span>
                </div>
                <a href="{{ route('puntos-interes.deportes-aventura.show', $rel->slug) }}" class="block w-full px-3 py-2 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full text-xs font-semibold hover:shadow-lg transition-all text-center">
                    Ver detalle
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- CTA Final -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] rounded-[32px] p-8 md:p-12 text-center text-white">
        <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">¿Listo para la aventura?</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Prepara tu equipo, verifica el clima y disfruta de esta increíble experiencia de aventura en Colombia.</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('puntos-interes.deportes-aventura') }}" class="px-8 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
                Ver más actividades
            </a>
            <a href="https://www.google.com/maps/search/{{ urlencode($item->nombre . ' ' . ($item->localidad ?? 'Colombia')) }}" target="_blank" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                <i class="fas fa-map-marked-alt mr-2"></i>
                Google Maps
            </a>
        </div>
    </div>
</div>
@endsection
