@extends('layouts.premium')

@section('title', $item->nombre ?? 'Detalle')

@section('content')
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Hero Section Premium -->
    <div class="relative h-[400px] md:h-[500px] rounded-[32px] md:rounded-[40px] overflow-hidden mb-8 md:mb-12" style="box-shadow: 0 25px 60px rgba(0,0,0,0.15), 0 50px 100px rgba(0,0,0,0.1);">
        @if($item->imagen)
            <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-cyan-600 to-blue-700 flex items-center justify-center">
                <svg class="w-24 h-24 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 lg:p-16 text-white">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm md:text-base font-medium mb-4" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                <span>{{ $tipo ?? 'Destino' }}</span>
            </div>
            <h1 class="font-display text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 20px rgba(0,0,0,0.5);">
                {{ $item->nombre }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 md:gap-6 text-sm md:text-base opacity-90">
                @if($item->localidad)
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $item->localidad }}
                </span>
                @endif
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Colombia
                </span>
            </div>
        </div>
    </div>

    <!-- Información Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 mb-8 md:mb-12">
        <!-- Descripción -->
        <div class="lg:col-span-2 bg-white/90 backdrop-blur-sm p-6 md:p-8 rounded-[28px] border border-white/40" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
            <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6">Descripción</h2>
            <p class="text-gray-600 leading-relaxed text-base md:text-lg">
                {{ $item->descripcion ?? 'No hay descripción disponible.' }}
            </p>
        </div>

        <!-- Información Adicional -->
        <div class="bg-white/90 backdrop-blur-sm p-6 md:p-8 rounded-[28px] border border-white/40" style="box-shadow: 0 8px 24px rgba(0,0,0,0.06), 0 16px 48px rgba(0,0,0,0.04), inset 0 1px 0 rgba(255,255,255,0.9);">
            <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900 mb-6">Información</h2>
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                    <div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium mb-1">Ubicación</div>
                        <div class="font-semibold text-midnight-900">{{ $item->localidad ?? 'No especificada' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium mb-1">ID</div>
                        <div class="font-semibold text-midnight-900">{{ $item->id }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón de regreso -->
    <div class="mb-8">
        <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-600 border-2 border-gray-200 rounded-2xl font-semibold transition-all duration-300 hover:border-cyan-500 hover:text-cyan-600 hover:shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver
        </a>
    </div>
</div>
@endsection
