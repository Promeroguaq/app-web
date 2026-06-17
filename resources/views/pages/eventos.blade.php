@extends('layouts.premium')

@section('title', 'Fiestas y Ferias')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section Cinematic -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #f472b6 0%, #ec4899 50%, #db2777 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            Celebraciones Colombianas
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Fiestas y Ferias
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Vive celebraciones llenas de música, tradición, color y memoria cultural.
        </p>
    </div>
</div>

<!-- Premium Filters -->
<div class="glass-card p-6 mb-12 rounded-[32px]">
    <div class="flex flex-wrap gap-3 justify-center">
        @php
            $tipoActual = request()->get('tipo', 'Todos');
        @endphp
        <a href="{{ route('eventos') }}" class="px-6 py-3 rounded-full font-semibold text-sm transition-all {{ $tipoActual === 'Todos' ? 'bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white shadow-lg' : 'bg-white/50 text-gray-600 hover:bg-white/80' }}">
            Todos
        </a>
        <a href="{{ route('eventos', ['tipo' => 'Carnaval']) }}" class="px-6 py-3 rounded-full font-semibold text-sm transition-all {{ $tipoActual === 'Carnaval' ? 'bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white shadow-lg' : 'bg-white/50 text-gray-600 hover:bg-white/80' }}">
            Carnavales
        </a>
        <a href="{{ route('eventos', ['tipo' => 'Feria']) }}" class="px-6 py-3 rounded-full font-semibold text-sm transition-all {{ $tipoActual === 'Feria' ? 'bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white shadow-lg' : 'bg-white/50 text-gray-600 hover:bg-white/80' }}">
            Ferias
        </a>
        <a href="{{ route('eventos', ['tipo' => 'Festival']) }}" class="px-6 py-3 rounded-full font-semibold text-sm transition-all {{ $tipoActual === 'Festival' ? 'bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white shadow-lg' : 'bg-white/50 text-gray-600 hover:bg-white/80' }}">
            Festivales
        </a>
        <a href="{{ route('eventos', ['tipo' => 'Música']) }}" class="px-6 py-3 rounded-full font-semibold text-sm transition-all {{ $tipoActual === 'Música' ? 'bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white shadow-lg' : 'bg-white/50 text-gray-600 hover:bg-white/80' }}">
            Música
        </a>
        <a href="{{ route('eventos', ['tipo' => 'Cultura']) }}" class="px-6 py-3 rounded-full font-semibold text-sm transition-all {{ $tipoActual === 'Cultura' ? 'bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white shadow-lg' : 'bg-white/50 text-gray-600 hover:bg-white/80' }}">
            Cultura
        </a>
    </div>
</div>

@if(isset($error))
<div class="glass-card p-8 mb-8 text-center text-red-600 rounded-[32px]">
    <strong>Error:</strong> {{ $error }}
</div>
@endif

<!-- Featured Event -->
@if($ferias->isNotEmpty())
@php
    $featured = $ferias->first();
@endphp
<div class="mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Evento Imperdible</h2>
    </div>
    
    <a href="/eventos/{{ $featured->slug }}" class="block group">
        <div class="relative h-[400px] md:h-[500px] rounded-[32px] overflow-hidden shadow-[0_18px_50px_rgba(0,0,0,0.18)] transition-all duration-500 group-hover:-translate-y-2 group-hover:scale-[1.01]">
            @if($featured->imagen)
                <img src="{{ $featured->imagen }}" alt="{{ $featured->nombre }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            @else
                <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-[#ec4899] to-[#be185d] flex items-center justify-center">
                    <span class="text-8xl md:text-9xl">🎉</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/10"></div>
            
            <div class="absolute inset-0 flex flex-col justify-between p-8 md:p-12 text-white">
                <div class="flex justify-between items-start">
                    <div class="glass-badge bg-[#1D4ED8]/30 px-4 py-2">
                        {{ $featured->categoria }}
                    </div>
                    <div class="glass-badge px-4 py-2">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ $featured->fecha }}
                    </div>
                </div>
                
                <div>
                    <h3 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                        {{ $featured->nombre }}
                    </h3>
                    <p class="text-lg md:text-xl opacity-90 mb-6 max-w-2xl line-clamp-2" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
                        {{ $featured->descripcion }}
                    </p>
                    <div class="flex items-center gap-2 text-sm md:text-base opacity-90 mb-6">
                        <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                        <span>{{ $featured->ciudad }}, {{ $featured->departamento }}</span>
                    </div>
                    <button class="px-8 py-4 bg-white text-midnight-900 rounded-full font-semibold hover:bg-white/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 text-sm md:text-base">
                        Explorar evento
                    </button>
                </div>
            </div>
        </div>
    </a>
</div>
@endif

<!-- Events Grid -->
<div class="mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Más Celebraciones</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        @forelse($ferias->slice(1) as $feria)
        <a href="/eventos/{{ $feria->slug }}" class="block group">
            <div class="relative min-h-[420px] rounded-[32px] overflow-hidden shadow-[0_18px_50px_rgba(0,0,0,0.18)] transition-all duration-500 group-hover:-translate-y-2 group-hover:scale-[1.01]">
                @if($feria->imagen)
                    <img src="{{ $feria->imagen }}" alt="{{ $feria->nombre }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-[#ec4899] to-[#be185d] flex items-center justify-center">
                        <span class="text-6xl md:text-7xl">🎉</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/10"></div>
                
                <div class="absolute inset-0 flex flex-col justify-between p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div class="glass-badge bg-[#1D4ED8]/30 px-3 py-1.5 text-xs">
                            {{ $feria->categoria }}
                        </div>
                        <div class="glass-badge px-3 py-1.5 text-xs">
                            <i class="fas fa-calendar-alt mr-1"></i>{{ $feria->fecha }}
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-display text-xl md:text-2xl font-bold mb-2 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                            {{ $feria->nombre }}
                        </h3>
                        <p class="text-sm opacity-90 mb-3 line-clamp-2" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
                            {{ Str::limit($feria->descripcion, 80) }}
                        </p>
                        <div class="flex items-center gap-2 text-xs opacity-90">
                            <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                            <span>{{ $feria->ciudad }}, {{ $feria->departamento }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full glass-card p-12 text-center text-gray-500 rounded-[32px]">
            <i class="fas fa-calendar-times text-4xl mb-4 opacity-50"></i>
            <p class="text-lg">No hay fiestas y ferias registradas en este momento.</p>
        </div>
        @endforelse
    </div>
</div>

</div>
@endsection
