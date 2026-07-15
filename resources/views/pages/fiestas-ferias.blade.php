@extends('layouts.premium')

@section('title', 'Fiestas y Ferias')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Immersive -->
@if($eventoDestacado)
<div class="hero-section rounded-[28px] md:rounded-[32px] mb-8 md:mb-12 w-full overflow-hidden relative min-h-[420px] md:min-h-[460px]">
    @if($eventoDestacado['imagen'])
        <img src="{{ $eventoDestacado['imagen'] }}" alt="{{ $eventoDestacado['nombre'] }}" class="absolute inset-0 w-full h-full object-cover">
    @else
        <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-[#ec4899] to-[#be185d]"></div>
    @endif
    <div class="hero-overlay rounded-[28px] md:rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-8 lg:p-10 xl:p-16 text-white">
        <div class="glass-badge inline-block mb-3 md:mb-4 lg:mb-6">
            🎉 {{ $eventoDestacado['mes'] ?? 'Evento destacado' }}
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-2 md:mb-3 lg:mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            {{ $eventoDestacado['nombre'] }}
        </h1>
        <p class="text-sm md:text-base lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-2xl mb-3 md:mb-4" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            {{ $eventoDestacado['ciudad_departamento'] ?? ($eventoDestacado['ciudad'] . ($eventoDestacado['departamento'] ? ', ' . $eventoDestacado['departamento'] : '')) }}
        </p>
        <p class="text-xs md:text-sm opacity-80 max-w-full md:max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            {{ Str::limit($eventoDestacado['descripcion'], 150) }}
        </p>
    </div>
</div>
@else
<div class="hero-section rounded-[28px] md:rounded-[32px] mb-8 md:mb-12 w-full overflow-hidden relative min-h-[420px] md:min-h-[460px]" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 50%, #be185d 100%);">
    <div class="hero-overlay rounded-[28px] md:rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-8 lg:p-10 xl:p-16 text-white">
        <div class="glass-badge inline-block mb-3 md:mb-4 lg:mb-6">
            🎉 Cultura
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-2 md:mb-3 lg:mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Fiestas y Ferias de Colombia
        </h1>
        <p class="text-sm md:text-base lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Descubre celebraciones, carnavales, ferias y tradiciones culturales durante todo el año.
        </p>
    </div>
</div>
@endif

<!-- Stats Section -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 md:mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#ec4899] mb-2">{{ $stats['total'] }}</div>
        <div class="text-sm text-gray-600">Fiestas y Ferias</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#ec4899] mb-2">{{ $stats['departamentos'] }}</div>
        <div class="text-sm text-gray-600">Departamentos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#ec4899] mb-2">{{ $stats['ciudades'] }}</div>
        <div class="text-sm text-gray-600">Ciudades</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#ec4899] mb-2">{{ $stats['meses'] }}</div>
        <div class="text-sm text-gray-600">Meses con Eventos</div>
    </div>
</div>

<!-- Calendario de Fiestas y Ferias -->
<div class="flex items-center gap-3 mb-8">
    <div class="w-1 h-8 bg-gradient-to-b from-[#ec4899] to-[#be185d] rounded-full"></div>
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Calendario de Fiestas y Ferias</h2>
</div>

@forelse($feriasPorMesOrdenadas as $mes => $ferias)
<!-- Month Section -->
<div class="mb-8 md:mb-12">
    <h3 class="font-display text-xl md:text-2xl font-bold text-midnight-900 mb-4 md:mb-6 flex items-center gap-3">
        <span class="w-2 h-8 bg-gradient-to-b from-[#ec4899] to-[#be185d] rounded-full"></span>
        {{ $mes }}
    </h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        @foreach($ferias as $feria)
        <x-cards.tourism-card
            :id="$feria['id']"
            :title="$feria['nombre']"
            :description="$feria['descripcion'] ?? 'Información turística en actualización.'"
            :image="$feria['imagen']"
            :badge="'🎉 ' . ($feria['mes'] ?? 'Evento')"
            :location="$feria['ciudad_departamento'] ?? ($feria['ciudad'] . ($feria['departamento'] ? ', ' . $feria['departamento'] : '')) ?? 'Colombia'"
            :detailUrl="route('fiestas-ferias.show', $feria['id'])"
            :fallbackTheme="'culture'"
        />
        @endforeach
    </div>
</div>
@empty
<div class="glass-card p-8 md:p-12 text-center text-gray-500 rounded-[32px]">
    <i class="fas fa-calendar-alt text-3xl md:text-4xl mb-3 md:mb-4 opacity-50"></i>
    <p class="text-sm md:text-lg">No hay fiestas y ferias registradas en este momento.</p>
</div>
@endforelse

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
@endsection
