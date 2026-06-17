@extends('layouts.premium')

@section('title', $feria->nombre ?? 'Detalle de Evento')

@section('content')
<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12 @if(isset($feria->imagen) && $feria->imagen) @else bg-gradient-to-br from-pink-600 to-purple-700 @endif">
    @if(isset($feria->imagen) && $feria->imagen)
    <img src="{{ $feria->imagen }}" alt="{{ $feria->nombre }}" class="hero-image rounded-[32px]">
    @endif
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            {{ $feria->categoria ?? 'Evento' }}
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            {{ $feria->nombre }}
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            {{ $feria->descripcion }}
        </p>
    </div>
</div>

<!-- Event Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="w-16 h-16 bg-[#1D4ED8]/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-calendar-alt text-2xl text-[#1D4ED8]"></i>
        </div>
        <div class="text-2xl font-bold text-midnight-900 mb-2">{{ $feria->fecha ?? 'Por definir' }}</div>
        <div class="text-sm text-gray-600">Fecha</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="w-16 h-16 bg-[#1D4ED8]/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-map-marker-alt text-2xl text-[#1D4ED8]"></i>
        </div>
        <div class="text-2xl font-bold text-midnight-900 mb-2">{{ $feria->ciudad ?? 'Colombia' }}</div>
        <div class="text-sm text-gray-600">Ciudad</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="w-16 h-16 bg-[#1D4ED8]/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-flag text-2xl text-[#1D4ED8]"></i>
        </div>
        <div class="text-2xl font-bold text-midnight-900 mb-2">{{ $feria->departamento ?? 'Colombia' }}</div>
        <div class="text-sm text-gray-600">Departamento</div>
    </div>
</div>

<!-- Description Section -->
<div class="glass-card p-8 md:p-12 mb-12 rounded-[32px]">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Sobre el Evento</h2>
    </div>
    <p class="text-gray-700 text-lg leading-relaxed">
        {{ $feria->descripcion ?? 'Sin descripción disponible.' }}
    </p>
</div>

<!-- CTA Section -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px] mb-12">
    <h2 class="font-display text-3xl font-bold mb-4">¿Listo para vivir esta experiencia?</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
        Planifica tu visita y descubre la magia de {{ $feria->nombre }}
    </p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/eventos" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            ← Volver a Eventos
        </a>
        <a href="/destinos" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Explorar Destinos
        </a>
    </div>
</div>

<!-- Explorar más eventos Section -->
<div class="mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Explorar más eventos</h2>
    </div>

    <!-- Search and Filters -->
    <div class="glass-card p-6 mb-8 rounded-[32px]">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" id="searchEvents" placeholder="Buscar feria, festival o carnaval..." class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-[#1D4ED8] focus:ring-2 focus:ring-[#1D4ED8]/20 outline-none transition-all">
            </div>
            <!-- Month Filter -->
            <div class="md:w-48">
                <select id="filterMonth" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-[#1D4ED8] focus:ring-2 focus:ring-[#1D4ED8]/20 outline-none transition-all">
                    <option value="">Todos los meses</option>
                    @foreach($meses as $mes)
                        <option value="{{ $mes }}">{{ $mes }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Department Filter -->
            <div class="md:w-48">
                <select id="filterDepartment" class="w-full px-4 py-3 rounded-full border border-gray-200 focus:border-[#1D4ED8] focus:ring-2 focus:ring-[#1D4ED8]/20 outline-none transition-all">
                    <option value="">Todos los departamentos</option>
                    @foreach($departamentos as $depto)
                        <option value="{{ $depto }}">{{ $depto }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Related Events Grid -->
    <div id="eventsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($relatedEvents as $relatedEvent)
        <a href="/eventos/{{ $relatedEvent->slug }}" class="block group">
            <div class="relative min-h-[380px] rounded-[32px] overflow-hidden shadow-[0_18px_50px_rgba(0,0,0,0.18)] transition-all duration-500 group-hover:-translate-y-2 group-hover:scale-[1.01]">
                @if($relatedEvent->imagen)
                    <img src="{{ $relatedEvent->imagen }}" alt="{{ $relatedEvent->nombre }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-[#ec4899] to-[#be185d] flex items-center justify-center">
                        <span class="text-6xl md:text-7xl">🎉</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/10"></div>

                <div class="absolute inset-0 flex flex-col justify-between p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div class="glass-badge bg-[#1D4ED8]/30 px-3 py-1.5 text-xs">
                            {{ $relatedEvent->categoria }}
                        </div>
                        <div class="glass-badge px-3 py-1.5 text-xs">
                            <i class="fas fa-calendar-alt mr-1"></i>{{ $relatedEvent->fecha }}
                        </div>
                    </div>

                    <div>
                        <h3 class="font-display text-xl md:text-2xl font-bold mb-2 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                            {{ $relatedEvent->nombre }}
                        </h3>
                        <p class="text-sm opacity-90 mb-3 line-clamp-2" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
                            {{ Str::limit($relatedEvent->descripcion, 80) }}
                        </p>
                        <div class="flex items-center gap-2 text-xs opacity-90">
                            <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                            <span>{{ $relatedEvent->ciudad }}, {{ $relatedEvent->departamento }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full glass-card p-12 text-center text-gray-500 rounded-[32px]">
            <i class="fas fa-calendar-times text-4xl mb-4 opacity-50"></i>
            <p class="text-lg">No encontramos más eventos relacionados por ahora.</p>
            <a href="/eventos" class="inline-block mt-4 px-6 py-3 bg-[#1D4ED8] text-white rounded-full font-semibold hover:bg-[#1E40AF] transition-all">
                Ver calendario completo
            </a>
        </div>
        @endforelse
    </div>

    <!-- View All Events Button -->
    <div class="text-center">
        <a href="/eventos" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg hover:-translate-y-1 transition-all">
            Ver todos los eventos
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Script for search and filter -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchEvents');
    const monthFilter = document.getElementById('filterMonth');
    const departmentFilter = document.getElementById('filterDepartment');
    const eventsGrid = document.getElementById('eventsGrid');

    const events = @json($relatedEvents);

    function filterEvents() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedMonth = monthFilter.value;
        const selectedDepartment = departmentFilter.value;

        const filtered = events.filter(event => {
            const matchesSearch = !searchTerm ||
                event.nombre.toLowerCase().includes(searchTerm) ||
                (event.descripcion && event.descripcion.toLowerCase().includes(searchTerm)) ||
                (event.ciudad && event.ciudad.toLowerCase().includes(searchTerm)) ||
                (event.departamento && event.departamento.toLowerCase().includes(searchTerm));

            const matchesMonth = !selectedMonth || event.mes === selectedMonth;
            const matchesDepartment = !selectedDepartment || event.departamento === selectedDepartment;

            return matchesSearch && matchesMonth && matchesDepartment;
        });

        renderEvents(filtered);
    }

    function renderEvents(eventsToRender) {
        if (eventsToRender.length === 0) {
            eventsGrid.innerHTML = `
                <div class="col-span-full glass-card p-12 text-center text-gray-500 rounded-[32px]">
                    <i class="fas fa-calendar-times text-4xl mb-4 opacity-50"></i>
                    <p class="text-lg">No se encontraron eventos con estos filtros.</p>
                </div>
            `;
            return;
        }

        eventsGrid.innerHTML = eventsToRender.map(event => `
            <a href="/eventos/${event.slug}" class="block group">
                <div class="relative min-h-[380px] rounded-[32px] overflow-hidden shadow-[0_18px_50px_rgba(0,0,0,0.18)] transition-all duration-500 group-hover:-translate-y-2 group-hover:scale-[1.01]">
                    ${event.imagen
                        ? `<img src="${event.imagen}" alt="${event.nombre}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">`
                        : `<div class="absolute inset-0 w-full h-full bg-gradient-to-br from-[#ec4899] to-[#be185d] flex items-center justify-center">
                            <span class="text-6xl md:text-7xl">🎉</span>
                           </div>`
                    }
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/10"></div>
                    <div class="absolute inset-0 flex flex-col justify-between p-6 text-white">
                        <div class="flex justify-between items-start">
                            <div class="glass-badge bg-[#1D4ED8]/30 px-3 py-1.5 text-xs">
                                ${event.categoria}
                            </div>
                            <div class="glass-badge px-3 py-1.5 text-xs">
                                <i class="fas fa-calendar-alt mr-1"></i>${event.fecha}
                            </div>
                        </div>
                        <div>
                            <h3 class="font-display text-xl md:text-2xl font-bold mb-2 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                                ${event.nombre}
                            </h3>
                            <p class="text-sm opacity-90 mb-3 line-clamp-2" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
                                ${event.descripcion ? event.descripcion.substring(0, 80) + '...' : ''}
                            </p>
                            <div class="flex items-center gap-2 text-xs opacity-90">
                                <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                                <span>${event.ciudad}, ${event.departamento}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        `).join('');
    }

    searchInput.addEventListener('input', filterEvents);
    monthFilter.addEventListener('change', filterEvents);
    departmentFilter.addEventListener('change', filterEvents);
});
</script>

</div>
@endsection
