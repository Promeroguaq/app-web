@extends('layouts.premium')

@section('title', $item->nombre . ' - Actividad en Parque')

@section('content')
<!-- Hero del Detalle -->
<div class="relative rounded-[32px] overflow-hidden mb-12 max-w-7xl mx-auto min-h-[500px] shadow-2xl">
    @if($item->imagen)
        <div class="absolute inset-0">
            <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF]">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        </div>
    @endif
    
    <div class="relative z-10 h-full flex flex-col justify-end px-12 py-16 text-white">
        <div class="flex gap-3 mb-4">
            <span class="bg-[#1D4ED8]/90 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold border border-white/30">
                🌲 {{ $tipo ?? 'Actividad en Parque' }}
            </span>
            @if(isset($item->tags) && is_array($item->tags) && count($item->tags) > 0)
                @foreach($item->tags as $tag)
                    <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold border border-white/30">
                        {{ $tag }}
                    </span>
                @endforeach
            @endif
            @if($item->localidad)
                <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold border border-white/30">
                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $item->localidad }}
                </span>
            @endif
        </div>
        
        <h1 class="text-5xl font-extrabold mb-4 font-['Space_Grotesk'] leading-tight">
            {{ $item->nombre }}
        </h1>
        
        @if($item->departamento)
            <p class="text-xl opacity-90">
                {{ $item->departamento }}, Colombia
            </p>
        @endif
    </div>
</div>

<!-- Contenido Principal -->
<div class="max-w-7xl mx-auto mb-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Columna Izquierda: Descripción -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Descripción -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 font-['Space_Grotesk']">
                    <i class="fas fa-info-circle text-[#1D4ED8] mr-2"></i>
                    Descripción
                </h2>
                <div class="text-gray-600 leading-relaxed text-lg">
                    {!! nl2br($item->descripcion) !!}
                </div>
            </div>
            
            <!-- Información Práctica -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 font-['Space_Grotesk']">
                    <i class="fas fa-clipboard-list text-[#1D4ED8] mr-2"></i>
                    Información Práctica
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($item->localidad)
                    <div class="flex items-start gap-4">
                        <div class="bg-[#1D4ED8]/10 p-3 rounded-xl">
                            <i class="fas fa-map-marker-alt text-[#1D4ED8] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Ubicación</h3>
                            <p class="text-gray-600">{{ $item->localidad }}</p>
                            @if($item->departamento)
                                <p class="text-gray-500 text-sm">{{ $item->departamento }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    @if(isset($item->tags) && is_array($item->tags) && count($item->tags) > 0)
                    <div class="flex items-start gap-4">
                        <div class="bg-[#1D4ED8]/10 p-3 rounded-xl">
                            <i class="fas fa-tags text-[#1D4ED8] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Etiquetas</h3>
                            <p class="text-gray-600">{{ implode(', ', $item->tags) }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex items-start gap-4">
                        <div class="bg-[#1D4ED8]/10 p-3 rounded-xl">
                            <i class="fas fa-clock text-[#1D4ED8] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Duración</h3>
                            <p class="text-gray-600">Variable según actividad</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="bg-[#1D4ED8]/10 p-3 rounded-xl">
                            <i class="fas fa-users text-[#1D4ED8] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">Ideal para</h3>
                            <p class="text-gray-600">Familias, grupos y aventureros</p>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(isset($item->recomendaciones) && !empty($item->recomendaciones))
            <!-- Recomendaciones -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 font-['Space_Grotesk']">
                    <i class="fas fa-lightbulb text-[#1D4ED8] mr-2"></i>
                    Recomendaciones
                </h2>
                
                <div class="text-gray-600 leading-relaxed">
                    {!! nl2br($item->recomendaciones) !!}
                </div>
            </div>
            @endif
        </div>
        
        <!-- Columna Derecha: Mapa y Relacionados -->
        <div class="space-y-8">
            <!-- Google Maps -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 mb-4 font-['Space_Grotesk']">
                    <i class="fas fa-map-marked-alt text-[#1D4ED8] mr-2"></i>
                    Ubicación
                </h2>
                
                @if($item->localidad)
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($item->localidad . ' ' . ($item->departamento ?? 'Colombia')) }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="block w-full bg-[#1D4ED8] hover:bg-[#1E40AF] text-white text-center py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Abrir en Google Maps
                    </a>
                @else
                    <p class="text-gray-500 text-center py-4">
                        Ubicación no disponible
                    </p>
                @endif
            </div>
            
            <!-- Actividades Relacionadas -->
            @if(isset($item->actividades_relacionadas) && $item->actividades_relacionadas->count() > 0)
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 mb-4 font-['Space_Grotesk']">
                    <i class="fas fa-hiking text-[#1D4ED8] mr-2"></i>
                    Actividades Relacionadas
                </h2>
                
                <div class="space-y-4">
                    @foreach($item->actividades_relacionadas as $relacionada)
                    <a href="{{ route('puntos-interes.actividades-parques.show', $relacionada->id) }}" class="block group">
                        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-[#1D4ED8]/10 transition-all duration-300">
                            @if($relacionada->imagen)
                                <img src="{{ $relacionada->imagen }}" alt="{{ $relacionada->nombre }}" class="w-16 h-16 rounded-lg object-cover">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] flex items-center justify-center">
                                    <span class="text-2xl">🌲</span>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 group-hover:text-[#1D4ED8] transition-colors">
                                    {{ $relacionada->nombre }}
                                </h3>
                                <p class="text-sm text-gray-500">Ver detalles</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-[#1D4ED8] transition-colors"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Volver -->
            <a href="{{ route('puntos-interes.actividades-parques') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-4 rounded-xl font-bold transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a Actividades
            </a>
        </div>
    </div>
</div>
@endsection
