@extends('layouts.premium')

@section('title', 'Islas de Colombia')

@section('content')
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-8 md:py-12">

<!-- Hero Section -->
<div class="relative h-[300px] md:h-[400px] lg:h-[420px] rounded-[20px] md:rounded-[32px] overflow-hidden mb-6 md:mb-8 shadow-xl bg-gradient-to-br from-cyan-500 via-blue-500 to-indigo-600">
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 lg:p-12 text-white">
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs md:text-sm font-medium">🏝️ Caribe</span>
            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs md:text-sm font-medium">🌊 Pacífico</span>
            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs md:text-sm font-medium">🐠 Arrecifes</span>
            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs md:text-sm font-medium">🌴 Naturaleza</span>
        </div>
        <h1 class="font-display text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-2 md:mb-4">Islas de Colombia</h1>
        <p class="text-sm md:text-base lg:text-lg opacity-90 max-w-2xl">Explora mares, arrecifes, reservas naturales y culturas insulares únicas.</p>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-cyan-600 font-display mb-1 md:mb-2">{{ $items->count() }}</div>
        <div class="text-xs md:text-sm text-gray-600">Islas Registradas</div>
    </div>
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-blue-600 font-display mb-1 md:mb-2">2</div>
        <div class="text-xs md:text-sm text-gray-600">Océanos</div>
    </div>
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-indigo-600 font-display mb-1 md:mb-2">5</div>
        <div class="text-xs md:text-sm text-gray-600">Reservas</div>
    </div>
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-[#1D4ED8] font-display mb-1 md:mb-2">∞</div>
        <div class="text-xs md:text-sm text-gray-600">Aventuras</div>
    </div>
</div>

<!-- Featured Islands -->
<h2 class="font-display text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-4 md:mb-6">Islas Destacadas</h2>

@if($items->isEmpty())
<div class="bg-white/80 backdrop-blur-sm p-6 md:p-8 text-center rounded-[20px] md:rounded-[32px] shadow-lg mb-6 md:mb-8">
    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
        <i class="fas fa-umbrella-beach text-white text-2xl md:text-3xl"></i>
    </div>
    <h3 class="font-display text-lg md:text-xl font-bold text-gray-900 mb-2 md:mb-3">No hay islas registradas</h3>
    <p class="text-gray-600 text-sm md:text-base mb-4 md:mb-6">Pronto encontrarás información sobre las islas de Colombia.</p>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
    @foreach($items as $item)
    <a href="{{ route('islas.show', ['id' => $item->id]) }}" class="block rounded-[20px] md:rounded-[28px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer">
        <div class="relative h-48 md:h-56 overflow-hidden bg-gradient-to-br from-cyan-400 to-blue-500">
            @if($item->imagen)
            <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-3 left-3">
                <span class="px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-medium text-white">🏝️ Isla</span>
            </div>
        </div>
        <div class="p-4 md:p-5">
            <h3 class="font-display text-base md:text-lg font-bold text-midnight-900 mb-2 line-clamp-1">{{ $item->nombre }}</h3>
            <p class="text-gray-600 text-xs md:text-sm mb-3 line-clamp-2">{{ $item->descripcion ?? 'Explora este destino insular de Colombia.' }}</p>
            <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-cyan-600"></i>
                <span>Colombia</span>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endif

<!-- CTA Section -->
<div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 md:p-8 lg:p-12 text-center text-white rounded-[20px] md:rounded-[32px] shadow-lg mb-6 md:mb-8">
    <h2 class="font-display text-lg md:text-2xl lg:text-3xl xl:text-4xl font-bold mb-2 md:mb-4">Explora Más Destinos</h2>
    <p class="text-xs md:text-sm lg:text-base lg:text-lg opacity-90 mb-4 md:mb-8 max-w-full md:max-w-2xl mx-auto">Descubre otras categorías de naturaleza en Colombia</p>
    <div class="flex flex-wrap gap-3 md:gap-4 justify-center">
        <a href="/puntos-interes/playas" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-white text-cyan-600 rounded-full font-semibold text-xs md:text-sm hover:shadow-2xl transition-all hover:scale-105">
            🏖️ Playas
        </a>
        <a href="/puntos-interes/termales" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-white/20 text-white border-2 border-white/30 rounded-full font-semibold text-xs md:text-sm hover:bg-white/30 transition-all">
            🌡️ Termales
        </a>
        <a href="/puntos-interes/reservas-naturales" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-white/20 text-white border-2 border-white/30 rounded-full font-semibold text-xs md:text-sm hover:bg-white/30 transition-all">
            🌲 Reservas Naturales
        </a>
    </div>
</div>

</div>
@endsection
