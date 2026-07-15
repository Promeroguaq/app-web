@props([
    'title' => 'Rutas Colombia',
    'showSearch' => true,
    'showMenu' => true,
])

<!-- Mobile Header - Solo visible en móvil -->
<header class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-lg border-b border-gray-100 safe-area-top">
    <div class="flex items-center justify-between px-4 py-3">
        <!-- Logo -->
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                <i class="fas fa-mountain text-white text-sm"></i>
            </div>
            <span class="font-display font-bold text-lg text-gray-900">{{ $title }}</span>
        </div>

        <!-- Menu Button -->
        @if($showMenu)
        <button 
            id="mobile-menu-toggle"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors"
            aria-label="Abrir menú"
        >
            <i class="fas fa-bars text-gray-700"></i>
        </button>
        @endif
    </div>

    <!-- Search Bar - Compacto -->
    @if($showSearch)
    <div class="px-4 pb-3">
        <form action="{{ route('buscar') }}" method="GET" class="relative">
            <input 
                type="text" 
                name="q" 
                placeholder="Buscar destinos..."
                class="w-full px-4 py-2.5 pl-10 rounded-xl bg-gray-100 border-0 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
            >
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        </form>
    </div>
    @endif
</header>

<!-- Spacer para contenido -->
<div class="lg:hidden h-[{{ $showSearch ? '108px' : '56px' }}]"></div>

<style>
    .safe-area-top {
        padding-top: env(safe-area-inset-top, 0px);
    }
</style>
