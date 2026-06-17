@extends('layouts.premium')

@section('title', 'Museos')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section -->
<div class="relative h-[40vh] sm:h-[50vh] md:h-[60vh] lg:h-[75vh] min-h-[300px] md:min-h-[400px] lg:min-h-[600px] overflow-hidden rounded-[32px] mb-8 md:mb-12 w-full" style="background: linear-gradient(135deg, #92400e 0%, #b45309 50%, #78350f 100%);">
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
    <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 lg:p-16 text-white">
        <div class="bg-white/90 backdrop-blur-sm inline-block mb-3 md:mb-6 px-2 py-1 md:px-4 md:py-2 rounded-full text-[10px] md:text-sm font-semibold text-gray-800 shadow-md z-10">
            🏛️ Cultura
        </div>
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-7xl font-bold mb-2 md:mb-4 leading-tight" style="text-shadow: 2px 2px 12px rgba(0,0,0,0.8);">
            Museos de Colombia
        </h1>
        <p class="text-xs md:text-sm lg:text-lg xl:text-xl opacity-90 max-w-full md:max-w-3xl mb-4 md:mb-6" style="text-shadow: 1px 1px 6px rgba(0,0,0,0.6);">
            Descubre la historia, arte y cultura colombiana
        </p>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 lg:gap-6 mb-8 md:mb-12">
    <div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-purple-600 mb-2">{{ $items->count() }}</div>
        <div class="text-xs md:text-sm text-gray-600 font-medium">Museos</div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-purple-600 mb-2">500K</div>
        <div class="text-xs md:text-sm text-gray-600 font-medium">Obras de Arte</div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-purple-600 mb-2">32</div>
        <div class="text-xs md:text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 text-center rounded-[20px] md:rounded-[32px] shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-purple-600 mb-2">2M</div>
        <div class="text-xs md:text-sm text-gray-600 font-medium">Visitantes Anuales</div>
    </div>
</div>

<!-- Museos Destacados -->
<h2 class="font-display text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-4 md:mb-6 lg:mb-8 text-center">Museos Destacados</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">

    @forelse($items as $item)
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="{{ route('puntos-interes.museos.show', $item->id) }}" class="block">
            <div class="relative h-48 sm:h-52 md:h-56 overflow-hidden w-full @if(empty($item->imagen)) bg-gradient-to-br from-amber-700 to-amber-900 @endif">
                @if(!empty($item->imagen))
                <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/20 backdrop-blur-sm px-2 py-1 md:px-3 md:py-1.5 rounded-full text-[10px] md:text-xs text-white z-10">
                    🏛️ Museo
                </div>
                <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 text-white z-10">
                    <div class="flex gap-2 md:gap-4 text-[10px] md:text-sm font-medium">
                        <span><i class="fas fa-landmark mr-1 text-[10px] md:text-sm"></i> Cultura</span>
                        <span><i class="fas fa-history mr-1 text-[10px] md:text-sm"></i> Historia</span>
                    </div>
                </div>
            </div>
            <div class="p-4 md:p-5 bg-white">
                <h3 class="font-display text-base md:text-lg lg:text-xl font-bold text-gray-900 mb-2">{{ $item->nombre }}</h3>
                <p class="text-gray-600 text-xs md:text-sm mb-2 md:mb-3 line-clamp-2">{{ Str::limit($item->descripcion, 100) }}</p>
                <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
                    <i class="fas fa-map-marker-alt text-purple-500 text-xs md:text-sm"></i>
                    <span>{{ $item->ubicacion ?? 'Colombia' }}</span>
                </div>
            </div>
        </a>
    </div>
    @empty
    <div class="col-span-full bg-white/80 backdrop-blur-sm p-6 md:p-8 lg:p-12 text-center text-gray-500 rounded-[20px] md:rounded-[32px] shadow-lg">
        <i class="fas fa-landmark text-3xl md:text-4xl mb-3 md:mb-4 opacity-50"></i>
        <p class="text-sm md:text-lg mb-4">No hay museos registrados en este momento.</p>
        @if(isset($error))
        <p class="text-xs md:text-sm text-red-500 bg-red-50 p-3 md:p-4 rounded-xl">{{ $error }}</p>
        @endif
    </div>
    @endforelse

</div>

<!-- Explorar Más -->
<div class="bg-white/80 backdrop-blur-sm p-6 md:p-8 lg:p-12 text-center bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-[20px] md:rounded-[32px] shadow-lg">
    <h2 class="font-display text-xl sm:text-2xl md:text-3xl font-bold mb-3 md:mb-4">Explora Más Cultura</h2>
    <p class="text-sm md:text-base lg:text-lg opacity-90 mb-6 md:mb-8 max-w-full md:max-w-2xl mx-auto">Descubre otras categorías culturales en Colombia</p>
    <div class="flex flex-wrap gap-2 md:gap-4 justify-center">
        <a href="/iglesias" class="px-4 py-2 md:px-6 md:py-3 bg-white text-purple-600 rounded-full font-semibold hover:shadow-lg transition-all text-xs md:text-sm">
            ⛪ Iglesias
        </a>
        <a href="/fiestas-ferias" class="px-4 py-2 md:px-6 md:py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all text-xs md:text-sm">
            🎭 Fiestas
        </a>
        <a href="/eventos" class="px-4 py-2 md:px-6 md:py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all text-xs md:text-sm">
            🎭 Tradiciones
        </a>
    </div>
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
@endsection
