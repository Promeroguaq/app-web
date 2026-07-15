@extends('layouts.premium')

@section('title', 'Actividades')

@section('content')
<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🧗 Turismo y Aventura
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Actividades y Aventuras
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Vive experiencias únicas en Colombia
        </p>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">50+</div>
        <div class="text-sm text-gray-600 font-medium">Actividades</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">32</div>
        <div class="text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">100%</div>
        <div class="text-sm text-gray-600 font-medium">Seguro</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-2">24/7</div>
        <div class="text-sm text-gray-600 font-medium">Disponible</div>
    </div>
</div>

<!-- Actividades Destacadas -->
<h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6 text-center">Actividades Destacadas</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-12">

    @forelse($items as $item)
    <x-cards.tourism-card
        :id="$item->id"
        :title="$item->nombre"
        :description="$item->descripcion ?? 'Información turística en actualización.'"
        :image="$item->imagen"
        :badge="'🧗 Actividad'"
        :location="'Colombia'"
        :detailUrl="route('puntos-interes.actividades.show', $item->id)"
        :fallbackTheme="'adventure'"
    />
    @empty
    <div class="col-span-full glass-card p-12 text-center text-gray-500">
        <i class="fas fa-hiking text-4xl mb-4 opacity-50"></i>
        <p class="text-lg">No hay actividades registradas en este momento.</p>
    </div>
    @endforelse

</div>

<!-- Explorar Más -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Aventuras</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Descubre otras categorías de turismo en Colombia</p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/playas" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            🏖️ Playas
        </a>
        <a href="/islas" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🏝️ Islas
        </a>
        <a href="/reservas-naturales" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🌲 Reservas Naturales
        </a>
    </div>
</div>

</div>
@endsection
