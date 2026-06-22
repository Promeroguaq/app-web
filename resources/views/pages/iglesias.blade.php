@extends('layouts.premium')

@section('title', 'Turismo Religioso')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Immersive - Premium Religious Tourism -->
<div class="hero-section relative h-[320px] md:h-[400px] lg:h-[480px] rounded-[36px] mb-12 overflow-hidden" style="background: linear-gradient(135deg, #be185d 0%, #ec4899 20%, #db2777 40%, #be185d 60%, #9d174d 80%, #831843 100%); box-shadow: 0 25px 60px rgba(0,0,0,0.25), 0 50px 100px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.15);">
    <!-- Ambient Glow Effects -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-pink-400/15 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-rose-600/10 rounded-full blur-3xl"></div>
    
    <!-- Glassmorphism Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-black/10 backdrop-blur-[2px]"></div>
    
    <!-- Content -->
    <div class="relative h-full flex flex-col justify-end p-8 md:p-12 lg:p-16 text-white">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm md:text-base font-medium mb-6 max-w-fit" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <span>⛪</span>
            <span>Cultura</span>
        </div>
        
        <!-- Title -->
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 20px rgba(0,0,0,0.5);">
            Turismo Religioso
        </h1>
        
        <!-- Subtitle -->
        <p class="text-base md:text-lg lg:text-xl opacity-95 max-w-2xl leading-relaxed" style="text-shadow: 1px 1px 8px rgba(0,0,0,0.4);">
            Descubre el patrimonio religioso y arquitectónico
        </p>
    </div>
    
    <!-- Bottom Shine -->
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
</div>

<!-- Premium Stats - Enhanced 3D -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-pink-700 mb-2">{{ $items->count() ?? 0 }}</div>
        <div class="text-sm text-gray-600 font-medium">Templos</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-pink-700 mb-2">500</div>
        <div class="text-sm text-gray-600 font-medium">Años de Historia</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-pink-700 mb-2">32</div>
        <div class="text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-pink-700 mb-2">UNESCO</div>
        <div class="text-sm text-gray-600 font-medium">Patrimonio</div>
    </div>
</div>

<!-- Error Message -->
@if(isset($error))
<div class="col-span-full bg-red-50 p-6 text-center text-red-600 rounded-[28px] border border-red-100 mb-8" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06);">
    <strong>Error:</strong> {{ $error }}
</div>
@endif

<!-- Religious Tourism Cards - Premium 3D -->
<h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-8 text-center">Turismo Religioso Destacado</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
    
    @forelse($items as $item)
    <a href="{{ route('puntos-interes.iglesias.show', $item->id) }}" class="cinematic-card group cursor-pointer block">
        <div class="relative h-72 overflow-hidden rounded-t-3xl">
            @if($item->imagen)
                <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <div class="w-full h-full bg-gradient-to-br from-pink-600 to-rose-700 flex items-center justify-center">
                    <span class="text-6xl">⛪</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4">
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-pink-500/30 backdrop-blur-md border border-pink-400/30 text-white text-xs font-medium" style="box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2);">
                    <span>⛪</span>
                    <span>Religioso</span>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                <div class="flex gap-4 text-xs md:text-sm font-medium mb-2">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-church"></i> Religioso
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-landmark"></i> Patrimonio
                    </span>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white rounded-b-3xl border border-gray-100" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04);">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">{{ $item->nombre }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">{{ Str::limit($item->descripcion ?? 'Sin descripción', 100) }}</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-pink-600"></i>
                <span>{{ $item->localidad ?? 'Colombia' }}</span>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full bg-white/90 backdrop-blur-sm p-12 text-center text-gray-500 rounded-[32px] border border-white/40" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04);">
        <span class="text-6xl mb-4 block opacity-30">⛪</span>
        <p class="text-lg font-medium">No hay destinos de turismo religioso registrados en este momento.</p>
    </div>
    @endforelse
</div>

<!-- CTA Section - Premium -->
<div class="relative bg-gradient-to-r from-pink-600 to-rose-700 p-10 md:p-12 text-center text-white rounded-[36px] overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 40px 100px rgba(0,0,0,0.1);">
    <!-- Ambient Glow -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-pink-400/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-rose-500/10 rounded-full blur-3xl"></div>
    
    <!-- Content -->
    <div class="relative">
        <h2 class="font-display text-3xl md:text-4xl font-bold mb-4">Explora Más Cultura</h2>
        <p class="text-base md:text-lg opacity-90 mb-8 max-w-2xl mx-auto leading-relaxed">Descubre otras categorías culturales en Colombia</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/museos" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-pink-700 rounded-2xl font-semibold hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300" style="box-shadow: 0 6px 20px rgba(0,0,0,0.2);">
                <span>🏛️</span>
                <span>Museos</span>
            </a>
            <a href="/fiestas-y-ferias" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md text-white rounded-2xl font-semibold hover:bg-white/30 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 border border-white/30">
                <span>🎭</span>
                <span>Fiestas</span>
            </a>
            <a href="{{ route('puntos-interes.museos') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md text-white rounded-2xl font-semibold hover:bg-white/30 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 border border-white/30">
                <span>🎭</span>
                <span>Tradiciones</span>
            </a>
        </div>
    </div>
</div>

</div>
@endsection
