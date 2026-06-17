@extends('layouts.premium')

@section('title', 'Playas')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Immersive - Premium Ocean -->
<div class="hero-section relative h-[320px] md:h-[400px] lg:h-[480px] rounded-[36px] mb-12 overflow-hidden" style="background: linear-gradient(135deg, #0c4a6e 0%, #075985 20%, #0369a1 40%, #0284c7 60%, #0ea5e9 80%, #38bdf8 100%); box-shadow: 0 25px 60px rgba(0,0,0,0.25), 0 50px 100px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.15);">
    <!-- Ambient Glow Effects -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-400/15 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl"></div>
    
    <!-- Glassmorphism Overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-black/10 backdrop-blur-[2px]"></div>
    
    <!-- Content -->
    <div class="relative h-full flex flex-col justify-end p-8 md:p-12 lg:p-16 text-white">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm md:text-base font-medium mb-6 max-w-fit" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Paraíso Caribeño</span>
        </div>
        
        <!-- Title -->
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 20px rgba(0,0,0,0.5);">
            Playas Paradisíacas
        </h1>
        
        <!-- Subtitle -->
        <p class="text-base md:text-lg lg:text-xl opacity-95 max-w-2xl leading-relaxed" style="text-shadow: 1px 1px 8px rgba(0,0,0,0.4);">
            Descubre las playas más hermosas del Caribe colombiano
        </p>
    </div>
    
    <!-- Bottom Shine -->
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>
</div>

<!-- Premium Stats - Enhanced 3D -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-cyan-700 mb-2">{{ $items->count() ?? 0 }}</div>
        <div class="text-sm text-gray-600 font-medium">Playas</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-cyan-700 mb-2">1,600</div>
        <div class="text-sm text-gray-600 font-medium">km de Costa</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-cyan-700 mb-2">7</div>
        <div class="text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="relative bg-white/90 backdrop-blur-sm p-6 text-center rounded-[28px] border border-white/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
        <div class="text-3xl md:text-4xl font-bold text-cyan-700 mb-2">28°C</div>
        <div class="text-sm text-gray-600 font-medium">Temperatura Promedio</div>
    </div>
</div>

<!-- Beach Cards - Premium 3D -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-12">
    
    @forelse($items as $item)
    <a href="{{ route('puntos-interes.playas.show', $item->id) }}" class="cinematic-card group cursor-pointer block">
        <div class="relative h-72 overflow-hidden rounded-t-3xl">
            @if($item->imagen)
                <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <div class="w-full h-full bg-gradient-to-br from-cyan-600 to-blue-700 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-4 left-4">
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-cyan-500/30 backdrop-blur-md border border-cyan-400/30 text-white text-xs font-medium" style="box-shadow: 0 4px 12px rgba(6,182,212,0.2);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Playa</span>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                <div class="flex gap-4 text-xs md:text-sm font-medium mb-2">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        Aguas Cristalinas
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Sol Todo el Año
                    </span>
                </div>
            </div>
        </div>
        <div class="p-6 bg-white rounded-b-3xl border border-gray-100" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04);">
            <h3 class="font-display text-xl font-bold text-midnight-900 mb-2">{{ $item->nombre }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">{{ Str::limit($item->descripcion, 100) }}</p>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ $item->localidad ?? 'Colombia' }}</span>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full bg-white/90 backdrop-blur-sm p-12 text-center text-gray-500 rounded-[32px] border border-white/40" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04);">
        <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-lg font-medium">No hay playas registradas en este momento.</p>
    </div>
    @endforelse
</div>

<!-- CTA Section - Premium -->
<div class="relative bg-gradient-to-r from-cyan-600 to-blue-700 p-10 md:p-12 text-center text-white rounded-[36px] overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 40px 100px rgba(0,0,0,0.1);">
    <!-- Ambient Glow -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"></div>
    
    <!-- Content -->
    <div class="relative">
        <h2 class="font-display text-3xl md:text-4xl font-bold mb-4">Explora Más Destinos</h2>
        <p class="text-base md:text-lg opacity-90 mb-8 max-w-2xl mx-auto leading-relaxed">Descubre otras categorías de naturaleza en Colombia</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/islas" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-cyan-700 rounded-2xl font-semibold hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300" style="box-shadow: 0 6px 20px rgba(0,0,0,0.2);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Islas</span>
            </a>
            <a href="/termales" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md text-white rounded-2xl font-semibold hover:bg-white/30 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 border border-white/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                </svg>
                <span>Termales</span>
            </a>
            <a href="/reservas-naturales" class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md text-white rounded-2xl font-semibold hover:bg-white/30 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 border border-white/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                <span>Reservas Naturales</span>
            </a>
        </div>
    </div>
</div>

</div>
@endsection
