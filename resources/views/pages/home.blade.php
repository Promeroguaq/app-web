@extends('layouts.premium')

@section('title', 'Inicio')

@section('content')
<!-- Hero Section - Premium 2-Column Layout -->
<div class="relative min-h-[85vh] bg-gradient-to-br from-[#0a1929] via-[#0d2847] to-[#0f2d1a] overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-20 left-20 w-96 h-96 bg-emerald-500 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Left Column: Text + Metrics -->
            <div class="order-2 lg:order-1 space-y-8">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20">
                    <span class="text-2xl">🇨🇴</span>
                    <span class="text-white/90 text-sm font-medium tracking-wide">Explora Colombia</span>
                </div>
                
                <!-- Title -->
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight">
                    Descubre
                    <span class="block bg-gradient-to-r from-emerald-400 to-teal-300 bg-clip-text text-transparent">Colombia</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-lg md:text-xl text-white/80 max-w-xl leading-relaxed">
                    El país de la biodiversidad, cultura vibrante y aventura sin límites
                </p>
                
                <!-- Search Bar -->
                <div class="glass-card p-2 max-w-2xl">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="text" placeholder="¿Qué quieres explorar?" class="flex-1 px-4 py-3 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        <button class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>Buscar
                        </button>
                    </div>
                </div>
                
                <!-- Metrics Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-card p-4 rounded-2xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-emerald-400 mb-1">{{ $stats['destinos'] ?? 0 }}</div>
                        <div class="text-sm text-white/70 font-medium">Destinos</div>
                    </div>
                    <div class="glass-card p-4 rounded-2xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-emerald-400 mb-1">{{ $stats['departamentos'] ?? 0 }}</div>
                        <div class="text-sm text-white/70 font-medium">Departamentos</div>
                    </div>
                    <div class="glass-card p-4 rounded-2xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-emerald-400 mb-1">{{ $stats['actividades'] ?? 0 }}</div>
                        <div class="text-sm text-white/70 font-medium">Actividades</div>
                    </div>
                    <div class="glass-card p-4 rounded-2xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300">
                        <div class="text-3xl md:text-4xl font-bold text-emerald-400 mb-1">{{ $stats['turismo_religioso'] ?? 0 }}</div>
                        <div class="text-sm text-white/70 font-medium">Turismo Religioso</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Colombia Map -->
            <div class="order-1 lg:order-2 relative">
                <!-- Map Container -->
                <div class="relative w-full aspect-square lg:aspect-[4/3] max-w-lg mx-auto">
                    <!-- Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-teal-500/20 rounded-3xl blur-2xl"></div>
                    
                    <!-- Glass Card -->
                    <div class="relative glass-card rounded-3xl p-6 md:p-8 border border-white/10 overflow-hidden">
                        <!-- Colombia Map SVG Silhouette -->
                        <div class="relative w-full h-full flex items-center justify-center">
                            <svg viewBox="0 0 400 550" class="w-full h-full drop-shadow-2xl" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Colombia Silhouette - Simplified Premium Shape -->
                                <path d="M200 30 
                                         L220 50 L240 45 L260 60 L280 55 L300 70 L310 90 L320 110 L330 130 L340 150 L350 170 L360 190 L370 210 L380 230 L385 250 L380 270 L370 290 L360 310 L350 330 L340 350 L330 370 L320 390 L310 410 L300 430 L290 450 L280 470 L270 490 L260 510 L250 520 L240 530 L230 535 L220 530 L210 520 L200 510 L190 520 L180 530 L170 535 L160 530 L150 520 L140 510 L130 490 L120 470 L110 450 L100 430 L90 410 L80 390 L70 370 L60 350 L50 330 L40 310 L30 290 L20 270 L15 250 L20 230 L30 210 L40 190 L50 170 L60 150 L70 130 L80 110 L90 90 L100 70 L120 55 L140 60 L160 45 L180 50 Z" 
                                      fill="url(#colombiaGradient)" 
                                      stroke="rgba(255,255,255,0.3)" 
                                      stroke-width="2"
                                      class="hover:fill-emerald-400/80 transition-all duration-500 cursor-pointer"/>
                                
                                <!-- Gradient Definition -->
                                <defs>
                                    <linearGradient id="colombiaGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:rgba(16,185,129,0.6);stop-opacity:1" />
                                        <stop offset="50%" style="stop-color:rgba(45,212,191,0.5);stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:rgba(59,130,246,0.4);stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                
                                <!-- Location Pins -->
                                <circle cx="200" cy="150" r="6" fill="#10b981" class="animate-pulse">
                                    <animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite"/>
                                </circle>
                                <circle cx="150" cy="250" r="5" fill="#3b82f6" class="animate-pulse" style="animation-delay: 0.5s">
                                    <animate attributeName="r" values="5;8;5" dur="2s" repeatCount="indefinite"/>
                                </circle>
                                <circle cx="250" cy="300" r="5" fill="#10b981" class="animate-pulse" style="animation-delay: 1s">
                                    <animate attributeName="r" values="5;8;5" dur="2s" repeatCount="indefinite"/>
                                </circle>
                                <circle cx="180" cy="400" r="4" fill="#3b82f6" class="animate-pulse" style="animation-delay: 1.5s">
                                    <animate attributeName="r" values="4;7;4" dur="2s" repeatCount="indefinite"/>
                                </circle>
                            </svg>
                            
                            <!-- Floating Category Cards -->
                            <div class="absolute top-8 right-4 glass-card px-3 py-2 rounded-xl border border-white/20 hover:border-emerald-500/50 transition-all duration-300 cursor-pointer group">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🌿</span>
                                    <span class="text-white text-xs font-medium group-hover:text-emerald-400 transition-colors">Naturaleza</span>
                                </div>
                            </div>
                            
                            <div class="absolute top-1/3 left-2 glass-card px-3 py-2 rounded-xl border border-white/20 hover:border-emerald-500/50 transition-all duration-300 cursor-pointer group">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🎭</span>
                                    <span class="text-white text-xs font-medium group-hover:text-emerald-400 transition-colors">Cultura</span>
                                </div>
                            </div>
                            
                            <div class="absolute bottom-1/3 right-6 glass-card px-3 py-2 rounded-xl border border-white/20 hover:border-emerald-500/50 transition-all duration-300 cursor-pointer group">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🍽️</span>
                                    <span class="text-white text-xs font-medium group-hover:text-emerald-400 transition-colors">Gastronomía</span>
                                </div>
                            </div>
                            
                            <div class="absolute bottom-8 left-4 glass-card px-3 py-2 rounded-xl border border-white/20 hover:border-emerald-500/50 transition-all duration-300 cursor-pointer group">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🎉</span>
                                    <span class="text-white text-xs font-medium group-hover:text-emerald-400 transition-colors">Eventos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Destinos Destacados - Horizontal Scroll -->
<div class="mb-12">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6">Destinos Destacados</h2>

    <div class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide">
        @forelse($destinosDestacados as $destino)
        @php
            $destinationUrl = $destino['url'] ?? '#';
        @endphp
        @if($destinationUrl !== '#')
        <a href="{{ $destinationUrl }}" class="cinematic-card min-w-[300px] md:min-w-[380px] snap-start block">
        @else
        <div class="cinematic-card min-w-[300px] md:min-w-[380px] snap-start">
        @endif
            <div class="relative h-64 overflow-hidden">
                @if(!empty($destino['imagen']))
                    <img src="{{ $destino['imagen'] }}" alt="{{ $destino['nombre'] }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-forest-500 to-forest-700 flex items-center justify-center">
                        <span class="text-6xl">🗺️</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute top-4 left-4 glass-badge">
                    {{ $destino['categoria'] ?? 'Destino' }}
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="font-semibold">{{ $destino['calificacion'] ?? '4.5' }}</span>
                    </div>
                    <h3 class="font-display text-xl font-bold mb-1">{{ $destino['nombre'] }}</h3>
                    <div class="flex items-center gap-2 text-sm opacity-90">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $destino['ubicacion'] }}</span>
                    </div>
                </div>
            </div>
        @if($destinationUrl !== '#')
        </a>
        @else
        </div>
        @endif
        @empty
        <div class="w-full text-center py-12 text-gray-500">
            No hay destinos registrados para mostrar.
        </div>
        @endforelse
    </div>
</div>

<!-- Explorar por Categoría - Netflix Style -->
<div class="mb-12">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6">Explorar por Categoría</h2>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <a href="/playas" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-sky-500 to-blue-600">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-umbrella-beach text-2xl mb-2"></i>
                    <h3 class="font-bold">Playas</h3>
                </div>
            </div>
        </a>
        
        <a href="/gastronomia" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-amber-500 to-orange-600">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-utensils text-2xl mb-2"></i>
                    <h3 class="font-bold">Gastronomía</h3>
                </div>
            </div>
        </a>
        
        <a href="/eventos" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-purple-500 to-pink-600">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-calendar-alt text-2xl mb-2"></i>
                    <h3 class="font-bold">Eventos</h3>
                </div>
            </div>
        </a>
        
        <a href="/alojamiento" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-bed text-2xl mb-2"></i>
                    <h3 class="font-bold">Alojamiento</h3>
                </div>
            </div>
        </a>

        <a href="/puntos-interes/actividades-parques" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-tree text-2xl mb-2"></i>
                    <h3 class="font-bold">Naturaleza</h3>
                </div>
            </div>
        </a>
        
        <a href="/puntos-interes/deportes-aventura" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-orange-500 to-red-600">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-hiking text-2xl mb-2"></i>
                    <h3 class="font-bold">Aventura</h3>
                </div>
            </div>
        </a>
        
        <a href="/puntos-interes/museos" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-amber-600 to-yellow-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-landmark text-2xl mb-2"></i>
                    <h3 class="font-bold">Cultura</h3>
                </div>
            </div>
        </a>
        
        <a href="/departamentos" class="cinematic-card block group">
            <div class="relative h-40 overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <i class="fas fa-map text-2xl mb-2"></i>
                    <h3 class="font-bold">Regiones</h3>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
