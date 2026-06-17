@extends('layouts.premium')

@section('title', 'Deportes de Aventura')

@section('content')
<!-- Hero Premium -->
<div class="relative h-[420px] md:h-[480px] rounded-[32px] overflow-hidden mb-12 md:mb-16 max-w-7xl mx-auto" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%);">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🧗 Turismo y Aventura
        </div>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
            Deportes de Aventura
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl">
            Vive la adrenalina en los paisajes más espectaculares de Colombia
        </p>
        <div class="flex flex-wrap gap-3 mt-6">
            <span class="glass-badge text-sm">Aventura</span>
            <span class="glass-badge text-sm">Adrenalina</span>
            <span class="glass-badge text-sm">Naturaleza</span>
            <span class="glass-badge text-sm">Extremo</span>
            <span class="glass-badge text-sm">Seguro</span>
        </div>
    </div>
</div>

<!-- Métricas Elegantes -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">{{ $total ?? $items->count() }}</div>
            <div class="text-gray-600 text-sm font-medium">Actividades</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">{{ $destinosCount ?? 1 }}</div>
            <div class="text-gray-600 text-sm font-medium">Destinos</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">3</div>
            <div class="text-gray-600 text-sm font-medium">Niveles</div>
        </div>
        <div class="bg-white rounded-[24px] p-6 text-center shadow-sm">
            <div class="text-4xl md:text-5xl font-bold text-[#1D4ED8] mb-2">🛡️</div>
            <div class="text-gray-600 text-sm font-medium">Seguridad</div>
        </div>
    </div>
</div>

<!-- Actividades Destacadas -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-midnight-900 mb-8 text-center">Actividades Destacadas</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($items as $item)
        <div class="rounded-[28px] overflow-hidden bg-white shadow-[0_10px_35px_rgba(0,0,0,0.10)] hover:-translate-y-2 hover:scale-[1.01] transition-all duration-500 cursor-pointer group">
            <div class="relative h-56 overflow-hidden">
                @if($item->imagen)
                    <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] flex items-center justify-center">
                        <i class="fas fa-mountain text-white text-6xl"></i>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute top-4 left-4 bg-[#1D4ED8]/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs text-white font-semibold">
                    🧗 Aventura
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                    <div class="flex gap-4 text-sm font-medium">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-bolt"></i> Adrenalina
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-shield-alt"></i> Seguro
                        </span>
                    </div>
                </div>
            </div>
            <div class="p-5 md:p-6">
                <h3 class="font-display text-lg md:text-xl font-bold text-gray-900 mb-2">{{ $item->nombre }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $item->descripcion }}</p>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <i class="fas fa-map-marker-alt text-[#1D4ED8]"></i>
                    <span>{{ $item->localidad ?? 'Colombia' }}</span>
                </div>
                <a href="{{ route('puntos-interes.deportes-aventura.show', $item->slug) }}" class="block w-full mt-4 px-4 py-2.5 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold hover:shadow-lg transition-all text-sm text-center">
                    Ver actividad
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 text-gray-500">
            <i class="fas fa-mountain text-6xl mb-4 text-gray-300"></i>
            <p class="text-lg">No hay deportes de aventura registrados en este momento.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
@if($total > $perPage)
@php
    $totalPages = ceil($total / $perPage);
    $startPage = max(1, $page - 2);
    $endPage = min($totalPages, $page + 2);
@endphp
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="flex justify-center items-center gap-2">
        @if($page > 1)
            <a href="?page={{ $page - 1 }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @for($i = $startPage; $i <= $endPage; $i++)
            @if($i == $page)
                <span class="px-4 py-2 bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-full font-semibold">{{ $i }}</span>
            @else
                <a href="?page={{ $i }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">{{ $i }}</a>
            @endif
        @endfor

        @if($page < $totalPages)
            <a href="?page={{ $page + 1 }}" class="px-4 py-2 bg-white border border-gray-200 rounded-full text-gray-700 hover:bg-gray-50 transition-all">
                <i class="fas fa-chevron-right"></i>
            </a>
        @endif
    </div>
</div>
@endif

<!-- CTA Final -->
<div class="max-w-7xl mx-auto mb-12 md:mb-16">
    <div class="bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] rounded-[32px] p-8 md:p-12 text-center text-white">
        <h2 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold mb-4">Explora Más Actividades</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">Descubre otras categorías de turismo y aventura en Colombia</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('puntos-interes.ciclismo') }}" class="px-8 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
                🚴 Ciclismo
            </a>
            <a href="{{ route('puntos-interes.reservas-naturales') }}" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                🏞️ Reservas Naturales
            </a>
            <a href="{{ route('puntos-interes.parques-tematicos') }}" class="px-8 py-3 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold hover:bg-white/30 transition-all">
                🎢 Parques Temáticos
            </a>
        </div>
    </div>
</div>
@endsection
