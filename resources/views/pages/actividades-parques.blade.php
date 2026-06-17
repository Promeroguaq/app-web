@extends('layouts.premium')

@section('title', 'Actividades en Parques')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Immersive -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🌲 Naturaleza Viva
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Actividades en Parques
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Explora experiencias al aire libre, naturaleza y aventura en los parques de Colombia
        </p>
    </div>
</div>

<!-- Premium Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">{{ $stats['actividades'] ?? $items->count() }}</div>
        <div class="text-sm text-gray-600 font-medium">Actividades</div>
    </div>
    @if(isset($stats['con_imagen']) && $stats['con_imagen'] > 0)
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">{{ $stats['con_imagen'] }}</div>
        <div class="text-sm text-gray-600 font-medium">Con Imagen</div>
    </div>
    @endif
    @if(isset($stats['localidades']) && $stats['localidades'] > 0)
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">{{ $stats['localidades'] }}</div>
        <div class="text-sm text-gray-600 font-medium">Localidades</div>
    </div>
    @endif
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">{{ $stats['experiencias'] ?? $items->count() }}</div>
        <div class="text-sm text-gray-600 font-medium">Experiencias</div>
    </div>
</div>

<!-- Activity Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
    
    @forelse($items as $item)
    <a href="{{ route('puntos-interes.actividades-parques.show', $item->id) }}" class="cinematic-card group cursor-pointer block">
        <div class="relative h-72 overflow-hidden">
            @if($item->imagen)
                <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <div class="w-full h-full bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] flex items-center justify-center">
                    <span class="text-7xl">🌲</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4 glass-badge bg-[#1D4ED8]/30">
                🌲 Actividad
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                <div class="flex gap-4 text-sm font-medium mb-2">
                    @if(isset($item->tags) && is_array($item->tags) && count($item->tags) > 0)
                        @foreach($item->tags as $tag)
                            <span>{{ $tag }}</span>
                        @endforeach
                    @else
                        <span>Actividad</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="p-6">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">{{ $item->nombre }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($item->descripcion, 100) }}</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                <span>{{ $item->localidad ?? $item->departamento ?? 'Colombia' }}</span>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full glass-card p-12 text-center text-gray-500">
        <i class="fas fa-tree text-4xl mb-4 opacity-50"></i>
        <p class="text-lg">No hay actividades registradas en este momento.</p>
    </div>
    @endforelse
</div>

<!-- CTA Section -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Naturaleza</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Descubre otras categorías de naturaleza en Colombia</p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('puntos-interes.playas') }}" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            🏖️ Playas
        </a>
        <a href="{{ route('puntos-interes.reservas-naturales') }}" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🌲 Reservas Naturales
        </a>
        <a href="{{ route('puntos-interes.deportes-aventura') }}" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🧗 Deportes de Aventura
        </a>
    </div>
</div>

</div>
@endsection
