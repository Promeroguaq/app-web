@extends('layouts.premium')

@section('title', 'Capitales de Colombia')

@section('content')
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-8 md:py-12">

<!-- Hero Premium Redesign - Full Background Image -->
<div class="relative h-[240px] sm:h-[260px] md:h-[280px] lg:h-[300px] xl:h-[340px] overflow-hidden rounded-[32px] mb-6 md:mb-8 shadow-xl">
    <!-- Full background image - Bogotá urban landscape -->
    <img
        src="https://m.rutascolombia.com/Imagenes_app/capital_cities/bogota/bogoteatro.jpg"
        alt="Paisaje urbano de Bogotá, Colombia"
        class="absolute inset-0 w-full h-full object-cover"
        loading="eager"
        fetchpriority="high"
    >

    <!-- Progressive overlay - left to right gradient for text legibility -->
    <div class="absolute inset-0" style="background: linear-gradient(to right, #c2410c 0%, #c2410c 40%, rgba(194, 65, 12, 0.7) 60%, rgba(194, 65, 12, 0.3) 80%, rgba(194, 65, 12, 0.1) 100%);"></div>

    <!-- Bottom overlay for content integration -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#c2410c]/30 via-transparent to-transparent"></div>

    <!-- Decorative texture overlay - subtle urban/cartographic pattern -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>

    <!-- Main content -->
    <div class="absolute inset-0 flex items-center p-6 md:p-8 lg:p-12">
        <div class="relative z-10 max-w-2xl">
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs md:text-sm font-medium">🏛️ Geográficas</span>
                <span class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs md:text-sm font-medium">🗺️ Departamentos</span>
                <span class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs md:text-sm font-medium">🌆 Urbanas</span>
            </div>
            <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-2 md:mb-4 leading-tight" style="text-shadow: 0 2px 20px rgba(0,0,0,0.3);">
                Capitales de Colombia
            </h1>
            <p class="text-white/80 text-sm md:text-base lg:text-lg max-w-xl leading-relaxed">
                Explora las ciudades capitales de los departamentos de Colombia.
            </p>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-amber-600 font-display mb-1 md:mb-2">{{ $items->count() }}</div>
        <div class="text-xs md:text-sm text-gray-600">Capitales</div>
    </div>
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-orange-600 font-display mb-1 md:mb-2">32</div>
        <div class="text-xs md:text-sm text-gray-600">Departamentos</div>
    </div>
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-red-600 font-display mb-1 md:mb-2">5</div>
        <div class="text-xs md:text-sm text-gray-600">Regiones</div>
    </div>
    <div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 text-center shadow-lg">
        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-yellow-600 font-display mb-1 md:mb-2">∞</div>
        <div class="text-xs md:text-sm text-gray-600">Experiencias</div>
    </div>
</div>

<!-- Search -->
<div class="bg-white rounded-[16px] md:rounded-[20px] p-4 md:p-6 mb-6 md:mb-8 shadow-lg">
    <div class="relative">
        <input type="text" id="search-capitales" placeholder="Buscar capital..." class="w-full px-4 py-3 md:px-6 md:py-4 pl-12 rounded-full border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all text-sm md:text-base">
        <i class="fas fa-search absolute left-4 md:left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
    </div>
</div>

<!-- Capitales Grid -->
<h2 class="font-display text-xl md:text-2xl lg:text-3xl font-bold text-midnight-900 mb-4 md:mb-6">Capitales Departamentales</h2>

@if($items->isEmpty())
<div class="bg-white/80 backdrop-blur-sm p-6 md:p-8 text-center rounded-[20px] md:rounded-[32px] shadow-lg mb-6 md:mb-8">
    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-amber-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 md:mb-6">
        <i class="fas fa-landmark text-white text-2xl md:text-3xl"></i>
    </div>
    <h3 class="font-display text-lg md:text-xl font-bold text-gray-900 mb-2 md:mb-3">No hay capitales registradas</h3>
    <p class="text-gray-600 text-sm md:text-base mb-4 md:mb-6">Pronto encontrarás información sobre las capitales de Colombia.</p>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8" id="capitales-grid">
    @foreach($items as $item)
    <a href="{{ route('capitales.show', $item->slug) }}" class="block rounded-[20px] md:rounded-[28px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group cursor-pointer capital-card" data-nombre="{{ strtolower($item->nombre) }}">
        <div class="relative h-48 md:h-56 overflow-hidden bg-gradient-to-br from-amber-400 to-orange-500">
            @if($item->imagen)
            <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute top-3 left-3">
                <span class="px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-medium text-white">🏛️ Capital</span>
            </div>
        </div>
        <div class="p-4 md:p-5">
            <h3 class="font-display text-base md:text-lg font-bold text-midnight-900 mb-2 line-clamp-1">{{ $item->nombre }}</h3>
            <p class="text-gray-600 text-xs md:text-sm mb-3 line-clamp-2">{{ $item->descripcion ?? 'Capital departamental de Colombia.' }}</p>
            <div class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
                <i class="fas fa-map-marker-alt text-amber-600"></i>
                <span>Colombia</span>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endif

<!-- CTA Section -->
<div class="bg-gradient-to-r from-amber-500 to-orange-600 p-6 md:p-8 lg:p-12 text-center text-white rounded-[20px] md:rounded-[32px] shadow-lg mb-6 md:mb-8">
    <h2 class="font-display text-lg md:text-2xl lg:text-3xl xl:text-4xl font-bold mb-2 md:mb-4">Explora Más Categorías</h2>
    <p class="text-xs md:text-sm lg:text-base lg:text-lg opacity-90 mb-4 md:mb-8 max-w-full md:max-w-2xl mx-auto">Descubre otras categorías geográficas de Colombia</p>
    <div class="flex flex-wrap gap-3 md:gap-4 justify-center">
        <a href="{{ route('departamentos.index') }}" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-white text-amber-600 rounded-full font-semibold text-xs md:text-sm hover:shadow-2xl transition-all hover:scale-105">
            🗺️ Departamentos
        </a>
        <a href="/departamentos" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-white/20 text-white border-2 border-white/30 rounded-full font-semibold text-xs md:text-sm hover:bg-white/30 transition-all">
            🏛️ Departamentos
        </a>
        <a href="/municipios" class="inline-block px-4 py-2 md:px-6 md:py-3 bg-white/20 text-white border-2 border-white/30 rounded-full font-semibold text-xs md:text-sm hover:bg-white/30 transition-all">
            🏙️ Municipios
        </a>
    </div>
</div>

</div>

<script>
document.getElementById('search-capitales').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.capital-card');
    
    cards.forEach(card => {
        const nombre = card.dataset.nombre || '';
        if (nombre.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection
