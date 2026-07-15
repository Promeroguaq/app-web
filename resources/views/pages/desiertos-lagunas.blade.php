@extends('layouts.premium')

@section('title', 'Desiertos y Lagunas')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Immersive - Premium Desert -->
<div class="hero-section relative h-[320px] md:h-[400px] lg:h-[480px] rounded-[36px] mb-12 overflow-hidden" style="background: linear-gradient(135deg, #d97706 0%, #b45309 20%, #92400e 40%, #78350f 60%, #713f12 80%, #451a03 100%); box-shadow: 0 25px 60px rgba(0,0,0,0.25), 0 50px 100px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.15);">
    <!-- Ambient Glow Effects -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-400/15 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-orange-600/10 rounded-full blur-3xl"></div>
    
    <!-- Glassmorphism Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-black/10 backdrop-blur-[2px]"></div>
    
    <!-- Content -->
    <div class="relative h-full flex flex-col justify-end p-8 md:p-12 lg:p-16 text-white">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm md:text-base font-medium mb-6 max-w-fit" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <span>🌴</span>
            <span>Naturaleza</span>
        </div>
        
        <!-- Title -->
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 20px rgba(0,0,0,0.5);">
            Desiertos y Lagunas
        </h1>
        
        <!-- Subtitle -->
        <p class="text-base md:text-lg lg:text-xl opacity-95 max-w-2xl leading-relaxed" style="text-shadow: 1px 1px 8px rgba(0,0,0,0.4);">
            Explora los paisajes áridos y cuerpos de agua de Colombia
        </p>
    </div>
    
    <!-- Bottom Shine -->
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
</div>

<!-- Premium Stats - Enhanced 3D -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-amber-700 mb-2">{{ $items->count() ?? 0 }}</div>
        <div class="text-sm text-gray-600 font-medium">Destinos</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-amber-700 mb-2">3</div>
        <div class="text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-amber-700 mb-2">35°C</div>
        <div class="text-sm text-gray-600 font-medium">Temperatura</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-amber-700 mb-2">100%</div>
        <div class="text-sm text-gray-600 font-medium">Natural</div>
    </div>
</div>

<!-- Desert & Lagoon Cards - Premium 3D -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-12">
    
    @forelse($items as $item)
    <x-cards.tourism-card
        :id="$item->id"
        :title="$item->nombre"
        :description="$item->descripcion ?? 'Información turística en actualización.'"
        :image="$item->imagen"
        :badge="'🏜️ Destino Natural'"
        :location="$item->locality_departamento ?? 'Colombia'"
        :secondaryLocation="$item->locality_municipio"
        :detailUrl="route('puntos-interes.desiertos-lagunas.show', $item->id)"
        :fallbackTheme="'nature'"
    />
    @empty
    <div class="col-span-full bg-white/90 backdrop-blur-sm p-12 text-center text-gray-500 rounded-[32px] border border-white/40" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04);">
        <span class="text-6xl mb-4 block opacity-30">🏜️</span>
        <p class="text-lg font-medium">No hay destinos de desiertos y lagunas registrados en este momento.</p>
    </div>
    @endforelse
</div>

<!-- CTA Section - Premium -->
<div class="relative bg-gradient-to-r from-amber-600 to-orange-700 p-10 md:p-12 text-center text-white rounded-[36px] overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 40px 100px rgba(0,0,0,0.1);">
    <!-- Ambient Glow -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-orange-500/10 rounded-full blur-3xl"></div>
    
    <!-- Content -->
    <div class="relative">
        <h2 class="font-display text-3xl md:text-4xl font-bold mb-4">Explora Más Naturaleza</h2>
        <p class="text-base md:text-lg opacity-90 mb-8 max-w-2xl mx-auto leading-relaxed">Descubre otras categorías de naturaleza en Colombia</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/playas" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-amber-700 rounded-2xl font-semibold hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300" style="box-shadow: 0 6px 20px rgba(0,0,0,0.2);">
                <span>🏖️</span>
                <span>Playas</span>
            </a>
            <a href="/islas" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md text-white rounded-2xl font-semibold hover:bg-white/30 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 border border-white/30">
                <span>🏝️</span>
                <span>Islas</span>
            </a>
            <a href="/reservas-naturales" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md text-white rounded-2xl font-semibold hover:bg-white/30 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 border border-white/30">
                <span>🌲</span>
                <span>Reservas Naturales</span>
            </a>
        </div>
    </div>
</div>

</div>
@endsection
