@props([
    'active' => 'ciudades',
])

<!-- Mobile Content Tabs - Chips de navegación -->
<div class="mb-6">
    <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2 -mx-4 px-4">
        @if(Route::has('capitales.index'))
        <!-- Ciudades -->
        <a 
            href="{{ route('capitales.index') }}"
            class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $active === 'ciudades' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
        >
            Ciudades
        </a>
        @endif

        @if(Route::has('departamentos.index'))
        <!-- Departamentos -->
        <a 
            href="{{ route('departamentos.index') }}"
            class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $active === 'departamentos' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
        >
            Departamentos
        </a>
        @endif

        @if(Route::has('municipios.index'))
        <!-- Municipios -->
        <a 
            href="{{ route('municipios.index') }}"
            class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $active === 'municipios' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
        >
            Municipios
        </a>
        @endif

        @if(Route::has('regiones'))
        <!-- Regiones -->
        <a 
            href="{{ route('regiones') }}"
            class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $active === 'regiones' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
        >
            Regiones
        </a>
        @endif
    </div>
</div>
