@extends('layouts.premium')

@section('title', $plato->nombre ?? 'Detalle de Plato')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden px-4 sm:px-6 lg:px-8">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12 relative overflow-hidden" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 50%, #a16207 100%);">
    @if($plato->imagen)
        <img src="{{ $plato->imagen }}" alt="{{ $plato->nombre }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
    @endif
    <div class="hero-overlay rounded-[32px] absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
    <div class="relative p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🍽️ {{ $plato->categoria ?? 'Plato Típico' }}
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            {{ $plato->nombre }}
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            {{ $plato->departamento }}
        </p>
    </div>
</div>

<!-- Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-12">
    <div class="glass-card p-6 rounded-[32px]">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-utensils text-orange-600 text-xl"></i>
            <span class="text-sm text-gray-600">Categoría</span>
        </div>
        <div class="text-lg font-bold text-gray-900">{{ $plato->categoria ?? 'No especificada' }}</div>
    </div>
    <div class="glass-card p-6 rounded-[32px]">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-map-marker-alt text-orange-600 text-xl"></i>
            <span class="text-sm text-gray-600">Departamento</span>
        </div>
        <div class="text-lg font-bold text-gray-900">{{ $plato->departamento }}</div>
    </div>
    <div class="glass-card p-6 rounded-[32px]">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-globe text-orange-600 text-xl"></i>
            <span class="text-sm text-gray-600">Región</span>
        </div>
        <div class="text-lg font-bold text-gray-900">{{ $plato->region ?? 'No especificada' }}</div>
    </div>
</div>

<!-- Pending Recipe Notice -->
@if(!$plato->detalle || $plato->detalle->estado_verification !== 'publicado')
<div class="glass-card p-6 md:p-8 rounded-[32px] mb-12 bg-amber-50 border-2 border-amber-200">
    <div class="flex items-start gap-4">
        <div class="text-4xl">📝</div>
        <div>
            <h2 class="font-display text-xl md:text-2xl font-bold text-amber-900 mb-2">Receta en proceso de documentación</h2>
            <p class="text-amber-800 leading-relaxed">
                Estamos investigando y verificando la receta tradicional de este plato con fuentes oficiales y confiables.
                La información completa estará disponible pronto.
            </p>
        </div>
    </div>
</div>
@endif

<!-- Recipe Summary (if published) -->
@if($plato->detalle && $plato->detalle->estado_verification === 'publicado')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-12">
    @if($plato->detalle->tiempo_preparacion)
    <div class="glass-card p-6 rounded-[32px]">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-clock text-orange-600 text-xl"></i>
            <span class="text-sm text-gray-600">Tiempo</span>
        </div>
        <div class="text-lg font-bold text-gray-900">{{ $plato->detalle->tiempo_preparacion }}</div>
    </div>
    @endif
    @if($plato->detalle->porciones)
    <div class="glass-card p-6 rounded-[32px]">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-users text-orange-600 text-xl"></i>
            <span class="text-sm text-gray-600">Porciones</span>
        </div>
        <div class="text-lg font-bold text-gray-900">{{ $plato->detalle->porciones }}</div>
    </div>
    @endif
    @if($plato->detalle->dificultad)
    <div class="glass-card p-6 rounded-[32px]">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-signal text-orange-600 text-xl"></i>
            <span class="text-sm text-gray-600">Dificultad</span>
        </div>
        <div class="text-lg font-bold text-gray-900">{{ $plato->detalle->dificultad }}</div>
    </div>
    @endif
</div>
@endif

<!-- Description -->
<div class="glass-card p-6 md:p-8 rounded-[32px] mb-12">
    <h2 class="font-display text-xl md:text-2xl font-bold text-midnight-900 mb-4">Descripción</h2>
    <p class="text-gray-700 leading-relaxed">{{ $plato->descripcion ?? 'Sin descripción disponible' }}</p>
</div>

<!-- Ingredients (if published) -->
@if($plato->detalle && $plato->detalle->estado_verification === 'publicado' && $plato->ingredientes && count($plato->ingredientes) > 0)
<div class="glass-card p-6 md:p-8 rounded-[32px] mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-orange-500 to-red-500 rounded-full"></div>
        <h2 class="font-display text-xl md:text-2xl font-bold text-midnight-900">Ingredientes</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach($plato->ingredientes as $ingrediente)
        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
            <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
            <div class="flex-1">
                <div class="font-semibold text-gray-900">{{ $ingrediente->nombre }}</div>
                @if($ingrediente->cantidad || $ingrediente->unidad)
                <div class="text-sm text-gray-600">
                    @if($ingrediente->cantidad){{ $ingrediente->cantidad }}@endif
                    @if($ingrediente->unidad) {{ $ingrediente->unidad }}@endif
                </div>
                @endif
                @if($ingrediente->observacion)
                <div class="text-sm text-gray-500 italic">{{ $ingrediente->observacion }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Preparation Steps (if published) -->
@if($plato->detalle && $plato->detalle->estado_verification === 'publicado' && $plato->pasos && count($plato->pasos) > 0)
<div class="glass-card p-6 md:p-8 rounded-[32px] mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-orange-500 to-red-500 rounded-full"></div>
        <h2 class="font-display text-xl md:text-2xl font-bold text-midnight-900">Preparación</h2>
    </div>
    <div class="space-y-4">
        @foreach($plato->pasos as $paso)
        <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white font-bold">
                {{ $paso->orden }}
            </div>
            <div class="flex-1 pt-1">
                <p class="text-gray-700 leading-relaxed">{{ $paso->instruccion }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Source (if published) -->
@if($plato->detalle && $plato->detalle->estado_verification === 'publicado' && $plato->detalle->fuente_nombre)
<div class="glass-card p-6 md:p-8 rounded-[32px] mb-12 bg-blue-50 border-2 border-blue-200">
    <div class="flex items-start gap-4">
        <div class="text-4xl">📚</div>
        <div>
            <h2 class="font-display text-xl md:text-2xl font-bold text-blue-900 mb-2">Fuente</h2>
            <p class="text-blue-800 leading-relaxed mb-2">
                <strong>{{ $plato->detalle->fuente_nombre }}</strong>
            </p>
            @if($plato->detalle->fuente_url)
            <a href="{{ $plato->detalle->fuente_url }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline">
                {{ $plato->detalle->fuente_url }}
            </a>
            @endif
            @if($plato->detalle->fecha_consulta)
            <p class="text-sm text-blue-600 mt-2">Consultado: {{ $plato->detalle->fecha_consulta }}</p>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Related Dishes -->
@if($relatedPlatos && $relatedPlatos->count() > 0)
<div class="mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-orange-500 to-red-500 rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Otros platos de {{ $plato->departamento }}</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        @foreach($relatedPlatos as $relatedPlato)
        <a href="{{ route('gastronomia.show', [$relatedPlato->department_slug, $relatedPlato->slug]) }}" class="cinematic-card group cursor-pointer bg-white block">
            <div class="relative h-64 overflow-hidden">
                @if($relatedPlato->imagen ?? null)
                    <img src="{{ $relatedPlato->imagen }}" alt="{{ $relatedPlato->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center">
                        <span class="text-6xl">🍽️</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                
                <div class="absolute top-4 left-4 glass-badge bg-orange-500/30">
                    {{ $relatedPlato->categoria ?? 'Plato Típico' }}
                </div>
            </div>
            
            <div class="p-5">
                <h3 class="font-display text-lg font-bold text-gray-900 mb-2">{{ $relatedPlato->nombre }}</h3>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-map-marker-alt text-orange-500"></i>
                    <span>{{ $relatedPlato->departamento }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<!-- Back Button -->
<div class="mb-8">
    <a href="{{ route('gastronomia') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full font-semibold hover:shadow-lg transition-all">
        <i class="fas fa-arrow-left"></i>
        Volver a Gastronomía
    </a>
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
@endsection
