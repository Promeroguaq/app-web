@extends('layouts.premium')

@section('title', $reserva->nombre ?? 'Reserva Natural')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Back Button -->
<div class="mb-8">
    <a href="{{ route('reservas-parques.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-green-600 transition-colors">
        <i class="fas fa-arrow-left"></i>
        Volver a Reservas y Parques
    </a>
</div>

<!-- Hero Section with Image -->
<div class="relative h-96 rounded-[32px] mb-12 overflow-hidden">
    @if($reserva->imagen ?? null)
        <img src="{{ $reserva->imagen }}" alt="{{ $reserva->nombre }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
            <span class="text-9xl">🌿</span>
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-4">
            @if($reserva->region)
                {{ $reserva->region }}
            @else
                Reserva Natural
            @endif
        </div>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold mb-4" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            {{ $reserva->nombre ?? 'Reserva Natural' }}
        </h1>
        <div class="flex items-center gap-2 text-lg opacity-90" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            <i class="fas fa-map-marker-alt"></i>
            @if($reserva->localidad)
                {{ $reserva->localidad }}
            @elseif($reserva->region)
                {{ $reserva->region }}
            @else
                Ubicación por confirmar
            @endif
        </div>
    </div>
</div>

<!-- Description Section -->
<div class="glass-card p-8 mb-12 rounded-[32px]">
    <h2 class="font-display text-2xl font-bold text-midnight-900 mb-6">Descripción</h2>
    <div class="prose prose-lg max-w-none text-gray-700">
        @if($reserva->descripcion)
            <p>{{ $reserva->descripcion }}</p>
        @else
            <p class="text-gray-500 italic">Descripción no disponible en este momento.</p>
        @endif
    </div>
</div>

<!-- Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="glass-card p-6 rounded-[28px]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Localidad</div>
                <div class="font-semibold text-midnight-900">
                    @if($reserva->localidad)
                        {{ $reserva->localidad }}
                    @else
                        Por confirmar
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="glass-card p-6 rounded-[28px]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                <i class="fas fa-globe text-emerald-600 text-xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Región</div>
                <div class="font-semibold text-midnight-900">
                    @if($reserva->region)
                        {{ $reserva->region }}
                    @else
                        Por confirmar
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="glass-card p-6 rounded-[28px]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                <i class="fas fa-leaf text-teal-600 text-xl"></i>
            </div>
            <div>
                <div class="text-sm text-gray-500">Tipo</div>
                <div class="font-semibold text-midnight-900">Área Protegida</div>
            </div>
        </div>
    </div>
</div>

<!-- Related Reserves -->
@if($relatedReservas && $relatedReservas->count() > 0)
<div class="mb-12">
    <h2 class="font-display text-2xl font-bold text-midnight-900 mb-6">Reservas y Parques Relacionados</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($relatedReservas as $related)
        <a href="{{ route('reservas-parques.show', $related->slug) }}" class="cinematic-card group cursor-pointer bg-white block rounded-[24px] overflow-hidden shadow-[0_8px_25px_rgba(0,0,0,0.08)] hover:-translate-y-1 hover:scale-[1.02] transition-all duration-300">
            <div class="relative h-40 overflow-hidden">
                @if($related->imagen ?? null)
                    <img src="{{ $related->imagen }}" alt="{{ $related->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                        <span class="text-5xl">🌿</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
            </div>
            <div class="p-4">
                <h3 class="font-display text-base font-bold text-midnight-900 mb-2">
                    {{ $related->nombre }}
                </h3>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class="fas fa-map-marker-alt text-green-500"></i>
                    @if($related->localidad)
                        {{ $related->localidad }}
                    @elseif($related->region)
                        {{ $related->region }}
                    @else
                        Ubicación por confirmar
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

</div>
@endsection
