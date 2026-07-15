@extends('layouts.premium')

@section('title', 'Regiones Naturales')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12 relative overflow-hidden h-[250px] md:h-[300px] lg:h-[340px]">
    <!-- Background Image -->
    <img src="https://m.rutascolombia.com/Imagenes_app/fotos_regions/regioncafetera.jpg" alt="Paisaje geográfico de Colombia" class="absolute inset-0 h-full w-full object-cover">
    
    <!-- Overlay Layers -->
    <div class="absolute inset-0 rounded-[32px]" style="background: linear-gradient(to right, rgba(15, 23, 42, 0.85) 0%, rgba(30, 58, 138, 0.6) 40%, rgba(30, 58, 138, 0.3) 70%, rgba(30, 58, 138, 0.1) 100%);"></div>
    <div class="absolute inset-0 rounded-[32px] bg-gradient-to-t from-blue-900/40 via-transparent to-transparent"></div>
    
    <!-- Content -->
    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12 lg:p-16 text-white">
        <div class="glass-badge inline-block mb-4 md:mb-6">
            Geografía
        </div>
        <h1 class="font-display text-3xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-3 md:mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Regiones de Colombia
        </h1>
        <p class="text-base md:text-lg lg:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Explora las 6 regiones naturales del país
        </p>
    </div>
</div>

<!-- Stats Section -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="bg-white rounded-[20px] md:rounded-[28px] p-4 md:p-6 text-center border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF]"></div>
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">6</div>
        <div class="text-xs md:text-sm text-gray-600">Regiones</div>
    </div>
    <div class="bg-white rounded-[20px] md:rounded-[28px] p-4 md:p-6 text-center border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF]"></div>
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">32</div>
        <div class="text-xs md:text-sm text-gray-600">Departamentos</div>
    </div>
    <div class="bg-white rounded-[20px] md:rounded-[28px] p-4 md:p-6 text-center border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF]"></div>
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">1.1M</div>
        <div class="text-xs md:text-sm text-gray-600">km²</div>
    </div>
    <div class="bg-white rounded-[20px] md:rounded-[28px] p-4 md:p-6 text-center border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF]"></div>
        <div class="text-3xl md:text-4xl font-bold text-[#1D4ED8] mb-1 md:mb-2">100%</div>
        <div class="text-xs md:text-sm text-gray-600">Diversidad</div>
    </div>
</div>

<!-- Regions Grid -->
<div class="flex items-center gap-3 mb-8">
    <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Regiones Naturales</h2>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12">
    @forelse($regions as $region)
    <x-cards.tourism-card
        :id="$region->id"
        :title="$region->name"
        :description="$region->description"
        :image="$region->image_url"
        :badge="'🌍 ' . $region->shortName"
        :location="$region->departments_count . ' ' . ($region->departments_count == 1 ? 'departamento' : 'departamentos')"
        :detailUrl="route('regiones.show', ['slug' => $region->slug])"
        :fallbackTheme="$region->slug"
    />
    @empty
    <div class="col-span-full glass-card p-8 md:p-12 text-center text-gray-500">
        <i class="fas fa-map text-3xl md:text-4xl mb-3 md:mb-4 opacity-50"></i>
        <p class="text-sm md:text-lg">No hay regiones registradas en este momento.</p>
    </div>
    @endforelse
</div>

<!-- CTA Section -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Destinos</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
        Descubre los departamentos de cada región
    </p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/departamentos" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            Departamentos
        </a>
        <a href="/playas" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Playas
        </a>
        <a href="/destinos" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Reservas Naturales
        </a>
    </div>
</div>

</div>
@endsection
