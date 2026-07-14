@php
    // Determinar estado activo basado en la ruta actual
    $active = 'inicio';
    
    if (request()->is('dashboard') || request()->is('/')) {
        $active = 'inicio';
    } elseif (request()->is('destinos') || request()->is('municipios*') || request()->is('departamentos*') || request()->is('capitales*')) {
        $active = 'destinos';
    } elseif (request()->is('categorias') || request()->is('puntos-interes*') || request()->is('playas*') || request()->is('museos*') || request()->is('iglesias*') || request()->is('termales*') || request()->is('reservas*') || request()->is('deportes*') || request()->is('islas*') || request()->is('desiertos*') || request()->is('gastronomia*')) {
        $active = 'categorias';
    } elseif (request()->is('regiones*')) {
        $active = 'regiones';
    } elseif (request()->is('configuracion*')) {
        $active = 'mas';
    }
@endphp

<!-- Mobile Bottom Navigation - Solo visible en móvil -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-lg border-t border-gray-200 safe-area-bottom">
    <div class="flex items-center justify-around px-2 py-2">
        @if(Route::has('dashboard'))
        <!-- Inicio -->
        <a 
            href="{{ route('dashboard') }}"
            class="flex flex-col items-center py-2 px-3 rounded-xl transition-colors {{ $active === 'inicio' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700' }}"
        >
            <i class="fas fa-home text-lg mb-1"></i>
            <span class="text-xs font-medium">Inicio</span>
        </a>
        @endif

        @if(Route::has('departamentos.index'))
        <!-- Destinos -->
        <a 
            href="{{ route('departamentos.index') }}"
            class="flex flex-col items-center py-2 px-3 rounded-xl transition-colors {{ $active === 'destinos' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700' }}"
        >
            <i class="fas fa-map-marker-alt text-lg mb-1"></i>
            <span class="text-xs font-medium">Destinos</span>
        </a>
        @endif

        @if(Route::has('categorias.index'))
        <!-- Categorías -->
        <button
            onclick="openCategorySheet()"
            class="flex flex-col items-center py-2 px-3 rounded-xl transition-colors {{ $active === 'categorias' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700' }}"
        >
            <i class="fas fa-th-large text-lg mb-1"></i>
            <span class="text-xs font-medium">Categorías</span>
        </button>
        @endif

        @if(Route::has('regiones'))
        <!-- Regiones -->
        <a 
            href="{{ route('regiones') }}"
            class="flex flex-col items-center py-2 px-3 rounded-xl transition-colors {{ $active === 'regiones' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700' }}"
        >
            <i class="fas fa-globe-americas text-lg mb-1"></i>
            <span class="text-xs font-medium">Regiones</span>
        </a>
        @endif

        @if(Route::has('configuracion'))
        <!-- Más -->
        <a 
            href="{{ route('configuracion') }}"
            class="flex flex-col items-center py-2 px-3 rounded-xl transition-colors {{ $active === 'mas' ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-700' }}"
        >
            <i class="fas fa-ellipsis-h text-lg mb-1"></i>
            <span class="text-xs font-medium">Más</span>
        </a>
        @endif
    </div>
</nav>

<!-- Spacer para contenido -->
<div class="lg:hidden h-[72px]"></div>

<style>
    .safe-area-bottom {
        padding-bottom: env(safe-area-inset-bottom, 0px);
    }
</style>
