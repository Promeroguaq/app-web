@extends('layouts.premium')

@section('title', $item->nombre ?? 'Capital')

@section('content')
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-8 md:py-12">

<!-- Back Button -->
<div class="mb-6 md:mb-8">
    <a href="{{ route('capitales.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
        <i class="fas fa-arrow-left"></i>
        <span>Volver a Capitales</span>
    </a>
</div>

<!-- Hero Section -->
@if($item->imagen)
<div class="relative h-[300px] md:h-[400px] lg:h-[480px] rounded-[32px] overflow-hidden mb-8 md:mb-12">
    <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12 text-white">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 rounded-full mb-4">
            <span>🏛️ Capital</span>
        </div>
        <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-2">{{ $item->nombre }}</h1>
        @if($item->departamento)
        <p class="text-lg opacity-90">{{ $item->departamento }}</p>
        @endif
    </div>
</div>
@else
<div class="relative h-[200px] md:h-[250px] rounded-[32px] overflow-hidden mb-8 md:mb-12 bg-gradient-to-br from-amber-500 to-orange-600">
    <div class="absolute inset-0 flex items-center justify-center">
        <i class="fas fa-landmark text-white/30 text-8xl"></i>
    </div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12 text-white">
        <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-2">{{ $item->nombre }}</h1>
        @if($item->departamento)
        <p class="text-lg opacity-90">{{ $item->departamento }}</p>
        @endif
    </div>
</div>
@endif

<!-- Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 md:mb-12">
    @if($item->departamento)
    <div class="bg-white rounded-[24px] p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-map-marker-alt text-amber-600 text-xl"></i>
            <span class="text-gray-600 text-sm">Departamento</span>
        </div>
        <p class="font-display text-xl font-bold text-gray-900">{{ $item->departamento }}</p>
    </div>
    @endif
    
    @if($item->region)
    <div class="bg-white rounded-[24px] p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-globe text-amber-600 text-xl"></i>
            <span class="text-gray-600 text-sm">Región</span>
        </div>
        <p class="font-display text-xl font-bold text-gray-900">{{ $item->region }}</p>
    </div>
    @endif
    
    <div class="bg-white rounded-[24px] p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-city text-amber-600 text-xl"></i>
            <span class="text-gray-600 text-sm">Tipo</span>
        </div>
        <p class="font-display text-xl font-bold text-gray-900">Capital Departamental</p>
    </div>
</div>

<!-- Description -->
<div class="bg-white rounded-[24px] p-8 md:p-12 shadow-sm mb-8 md:mb-12">
    <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 mb-6">Sobre {{ $item->nombre }}</h2>
    <div class="prose prose-lg max-w-none text-gray-700">
        <p>{{ $item->descripcion ?? 'Información turística en actualización.' }}</p>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-[32px] p-8 md:p-12 text-center text-white mb-8 md:mb-12">
    <h2 class="font-display text-2xl md:text-3xl font-bold mb-4">Explora Más Destinos</h2>
    <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Descubre otras capitales y departamentos de Colombia</p>
    <div class="flex gap-4 justify-center flex-wrap">
        <a href="{{ route('capitales.index') }}" class="px-6 py-3 bg-white text-amber-600 rounded-full font-semibold hover:shadow-lg transition-all">
            🏛️ Otras Capitales
        </a>
        <a href="{{ route('departamentos.index') }}" class="px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🗺️ Departamentos
        </a>
    </div>
</div>

</div>
@endsection
