<!-- Mobile Quick Categories - Accesos rápidos con iconos -->
<div id="categorias" class="mb-6">
    <h2 class="text-lg font-bold text-gray-900 mb-3 font-display">Explorar por categoría</h2>
    
    <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-2 -mx-4 px-4">
        @if(Route::has('puntos-interes.playas'))
        <!-- Playas -->
        <a href="{{ route('puntos-interes.playas') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-umbrella-beach text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Playas</span>
        </a>
        @endif

        @if(Route::has('puntos-interes.museos'))
        <!-- Museos -->
        <a href="{{ route('puntos-interes.museos') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-landmark text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Museos</span>
        </a>
        @endif

        @if(Route::has('puntos-interes.deportes-aventura'))
        <!-- Deportes de Aventura -->
        <a href="{{ route('puntos-interes.deportes-aventura') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-hiking text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Aventura</span>
        </a>
        @endif

        @if(Route::has('gastronomia'))
        <!-- Gastronomía -->
        <a href="{{ route('gastronomia') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-utensils text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Gastronomía</span>
        </a>
        @endif

        @if(Route::has('regiones'))
        <!-- Regiones -->
        <a href="{{ route('regiones') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-globe-americas text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Regiones</span>
        </a>
        @endif

        @if(Route::has('departamentos.index'))
        <!-- Departamentos -->
        <a href="{{ route('departamentos.index') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-map text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Departamentos</span>
        </a>
        @endif

        @if(Route::has('municipios.index'))
        <!-- Municipios -->
        <a href="{{ route('municipios.index') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-city text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Municipios</span>
        </a>
        @endif

        @if(Route::has('puntos-interes.reservas-naturales'))
        <!-- Reservas -->
        <a href="{{ route('puntos-interes.reservas-naturales') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-tree text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Reservas</span>
        </a>
        @endif

        @if(Route::has('puntos-interes.termales'))
        <!-- Termales -->
        <a href="{{ route('puntos-interes.termales') }}" class="flex-shrink-0 flex flex-col items-center gap-2 group">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                <i class="fas fa-hot-tub text-white text-xl"></i>
            </div>
            <span class="text-xs font-medium text-gray-700">Termales</span>
        </a>
        @endif
    </div>
</div>
