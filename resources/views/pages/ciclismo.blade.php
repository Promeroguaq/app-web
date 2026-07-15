@extends('layouts.premium')

@section('title', 'Ciclismo')

@section('content')
<!-- Hero Premium -->
<div class="relative h-[420px] md:h-[480px] rounded-[32px] overflow-hidden mb-12 md:mb-16 max-w-7xl mx-auto" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%);">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🚴 Aventura
        </div>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
            Rutas de Ciclismo
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl">
            Descubre recorridos para pedalear entre montañas, pueblos, paisajes y aventuras por Colombia.
        </p>
        <div class="flex flex-wrap gap-3 mt-6">
            <span class="glass-badge text-sm">Aventura</span>
            <span class="glass-badge text-sm">Naturaleza</span>
            <span class="glass-badge text-sm">Ruta escénica</span>
            <span class="glass-badge text-sm">Ciclismo de ruta</span>
            <span class="glass-badge text-sm">Recorridos por Colombia</span>
        </div>
        <div class="flex gap-4 mt-8">
            <button onclick="document.getElementById('rutas-destacadas').scrollIntoView({behavior: 'smooth'})" class="px-6 py-3 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all">
                Explorar rutas
            </button>
            <button onclick="document.getElementById('mapa-section').scrollIntoView({behavior: 'smooth'})" class="px-6 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                Ver mapa
            </button>
        </div>
    </div>
</div>

<!-- Métricas Elegantes -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">{{ $items->count() }}</div>
            <div class="text-gray-600 text-sm font-medium">Rutas</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">40km</div>
            <div class="text-gray-600 text-sm font-medium">Promedio</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">32</div>
            <div class="text-gray-600 text-sm font-medium">Departamentos</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">100%</div>
            <div class="text-gray-600 text-sm font-medium">Naturaleza</div>
        </div>
    </div>
</div>

<!-- Filtros Premium -->
<div class="max-w-7xl mx-auto mb-8 md:mb-12">
    <div class="flex flex-wrap gap-3 items-center">
        <span class="text-sm font-semibold text-gray-700 mr-2">Filtrar por:</span>
        <button onclick="filterRoutes('all')" class="filter-btn active px-4 py-2 bg-[#1D4ED8] text-white rounded-full text-sm font-medium hover:bg-[#1E40AF] transition-all" data-filter="all">
            Todas
        </button>
        <button onclick="filterRoutes('facil')" class="filter-btn px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium hover:bg-[#1D4ED8] hover:text-white transition-all" data-filter="facil">
            Fácil
        </button>
        <button onclick="filterRoutes('moderada')" class="filter-btn px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium hover:bg-[#1D4ED8] hover:text-white transition-all" data-filter="moderada">
            Moderada
        </button>
        <button onclick="filterRoutes('dificil')" class="filter-btn px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium hover:bg-[#1D4ED8] hover:text-white transition-all" data-filter="dificil">
            Difícil
        </button>
        <button onclick="filterRoutes('carretera')" class="filter-btn px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium hover:bg-[#1D4ED8] hover:text-white transition-all" data-filter="carretera">
            Carretera
        </button>
        <button onclick="filterRoutes('montana')" class="filter-btn px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium hover:bg-[#1D4ED8] hover:text-white transition-all" data-filter="montana">
            Montaña
        </button>
        <button onclick="filterRoutes('urbana')" class="filter-btn px-4 py-2 bg-white/80 backdrop-blur-sm text-gray-700 rounded-full text-sm font-medium hover:bg-[#1D4ED8] hover:text-white transition-all" data-filter="urbana">
            Urbana
        </button>
    </div>
</div>

<!-- Rutas Destacadas -->
<div id="rutas-destacadas" class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Rutas Destacadas</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        @forelse($items as $item)
        <x-cards.tourism-card
            :id="$item->id"
            :title="$item->nombre"
            :description="$item->descripcion ?? 'Información turística en actualización.'"
            :image="$item->imagen"
            :badge="'🚴 Ciclismo'"
            :location="$item->locality_departamento ?? 'Colombia'"
            :secondaryLocation="$item->locality_municipio"
            :detailUrl="route('puntos-interes.ciclismo.show', $item->id)"
            :fallbackTheme="'adventure'"
        />
        @empty
        <div class="col-span-full text-center py-16 text-gray-500">
            <i class="fas fa-bicycle text-6xl mb-4 text-gray-300"></i>
            <p class="text-lg">No hay rutas de ciclismo registradas en este momento.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Consejos para Ciclistas -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Consejos para Ciclistas</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">🪖</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Casco</h3>
            <p class="text-gray-600 text-sm">Usa siempre casco certificado para proteger tu cabeza en cualquier ruta.</p>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">💧</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Hidratación</h3>
            <p class="text-gray-600 text-sm">Lleva suficiente agua y bebidas isotónicas para rutas largas.</p>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">🔧</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Mantenimiento</h3>
            <p class="text-gray-600 text-sm">Revisa tu bicicleta antes de salir: frenos, cadena y presión.</p>
        </div>
        <div class="bg-[#f8f5f0] rounded-[24px] p-6 text-center">
            <div class="text-4xl mb-4">🌤️</div>
            <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Clima</h3>
            <p class="text-gray-600 text-sm">Consulta el clima y prepárate para condiciones variables.</p>
        </div>
    </div>
</div>

<!-- Mapa Section -->
<div id="mapa-section" class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Mapa de Rutas</h2>
    <div class="rounded-[32px] overflow-hidden bg-gradient-to-br from-[#F7F3EA] to-[#f0ebe3] h-[400px] flex items-center justify-center">
        <div class="text-center">
            <i class="fas fa-map-marked-alt text-6xl text-[#1D4ED8] mb-4"></i>
            <p class="text-gray-600 text-lg">Mapa interactivo de rutas de ciclismo</p>
            <p class="text-gray-500 text-sm mt-2">Próximamente disponible</p>
        </div>
    </div>
</div>

<!-- CTA Final -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] rounded-[32px] p-8 md:p-12 text-center text-white">
        <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">¿Listo para pedalear?</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Descubre rutas únicas que te conectarán con la naturaleza, cultura y paisajes de Colombia en dos ruedas.</p>
        <button class="px-8 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            Planear mi ruta
        </button>
    </div>
</div>

<script>
function filterRoutes(filter) {
    // Actualizar estado de botones
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-[#1D4ED8]', 'text-white');
        btn.classList.add('bg-white/80', 'text-gray-700');
    });
    
    const activeBtn = document.querySelector(`[data-filter="${filter}"]`);
    if (activeBtn) {
        activeBtn.classList.remove('bg-white/80', 'text-gray-700');
        activeBtn.classList.add('bg-[#1D4ED8]', 'text-white');
    }
    
    // Filtrar cards (simulado - en producción esto debería filtrar datos reales)
    const cards = document.querySelectorAll('#rutas-destacadas .rounded-\\[28px\\]');
    cards.forEach(card => {
        if (filter === 'all') {
            card.style.display = 'block';
        } else {
            // Para demo, mostramos todas las cards
            // En producción, esto debería filtrar basado en datos reales de dificultad/tipo
            card.style.display = 'block';
        }
    });
}
</script>
@endsection
