@extends('layouts.premium')

@section('title', 'Configuración')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Premium Header -->
<div class="relative bg-gradient-to-br from-[#07111F] via-[#0B1F2A] to-[#063B32] rounded-[32px] md:rounded-[40px] mb-8 md:mb-12 overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 0 0 1px rgba(255,255,255,0.05);">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-[0.03]">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="config-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#config-grid)"/>
        </svg>
    </div>
    
    <!-- Subtle Glow -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
    
    <!-- Content -->
    <div class="relative z-10 px-6 md:px-10 py-8 md:py-12">
        <div class="flex items-center gap-3 mb-3">
            <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-semibold rounded-full border border-emerald-500/30">
                Preferencias
            </span>
        </div>
        <h1 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2">Configuración</h1>
        <p class="text-gray-300 text-sm md:text-base max-w-2xl">Personaliza tu experiencia en Rutas Colombia</p>
    </div>
</div>

<!-- Configuration Layout -->
<div class="flex flex-col lg:flex-row gap-6 md:gap-8">
    <!-- Left Navigation - Desktop -->
    <div class="hidden lg:block w-64 flex-shrink-0">
        <div class="bg-white rounded-2xl border border-gray-200 p-4 sticky top-6" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
            <h3 class="font-display text-lg font-semibold text-midnight-900 mb-4 px-2">Menú</h3>
            <nav class="space-y-1">
                <a href="#general" class="config-nav-item active flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 bg-gradient-to-r from-[#07111F] to-[#0B1F2A] text-white shadow-md">
                    <i class="fas fa-sliders-h w-5 text-center"></i>
                    <span>General</span>
                </a>
                <a href="#preferencias" class="config-nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-compass w-5 text-center"></i>
                    <span>Preferencias</span>
                </a>
                <a href="#privacidad" class="config-nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-shield-alt w-5 text-center"></i>
                    <span>Privacidad</span>
                </a>
                <a href="#apariencia" class="config-nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-palette w-5 text-center"></i>
                    <span>Apariencia</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Mobile Navigation Tabs -->
    <div class="lg:hidden w-full overflow-x-auto pb-2 -mx-4 px-4">
        <div class="flex gap-2 min-w-max">
            <button class="config-tab-mobile active px-4 py-2 rounded-full text-xs font-medium bg-gradient-to-r from-[#07111F] to-[#0B1F2A] text-white shadow-md whitespace-nowrap" data-target="general">
                <i class="fas fa-sliders-h mr-2"></i>General
            </button>
            <button class="config-tab-mobile px-4 py-2 rounded-full text-xs font-medium bg-white text-gray-600 border border-gray-200 whitespace-nowrap" data-target="preferencias">
                <i class="fas fa-compass mr-2"></i>Preferencias
            </button>
            <button class="config-tab-mobile px-4 py-2 rounded-full text-xs font-medium bg-white text-gray-600 border border-gray-200 whitespace-nowrap" data-target="privacidad">
                <i class="fas fa-shield-alt mr-2"></i>Privacidad
            </button>
            <button class="config-tab-mobile px-4 py-2 rounded-full text-xs font-medium bg-white text-gray-600 border border-gray-200 whitespace-nowrap" data-target="apariencia">
                <i class="fas fa-palette mr-2"></i>Apariencia
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 min-w-0">
        <!-- General Section -->
        <div id="general" class="config-section bg-white rounded-2xl border border-gray-200 p-6 md:p-8 mb-6" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                    <i class="fas fa-sliders-h text-white"></i>
                </div>
                <div>
                    <h2 class="font-display text-xl font-semibold text-midnight-900">General</h2>
                    <p class="text-gray-500 text-sm">Configura tus preferencias básicas</p>
                </div>
            </div>
            
            <!-- Idioma -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Idioma de la interfaz</label>
                <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                    <span class="text-gray-700">Español</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">El idioma actual está configurado en español.</p>
            </div>

            <!-- Región Preferida -->
            <div class="mb-6">
                <label for="preferred-region" class="block text-sm font-medium text-gray-700 mb-2">Región preferida</label>
                <select id="preferred-region" data-setting="preferred-region" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all duration-200">
                    <option value="">Sin preferencia</option>
                    @foreach($regiones as $region)
                        <option value="{{ $region->slug }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Prioriza contenido de esta región en el Dashboard.</p>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                <button type="button" id="btn-reset-general" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-undo mr-2"></i>Restablecer
                </button>
                <button type="button" id="btn-save-general" class="px-6 py-3 bg-gradient-to-r from-[#07111F] to-[#0B1F2A] text-white rounded-xl text-sm font-medium hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-save mr-2"></i>Guardar preferencias
                </button>
            </div>
        </div>

        <!-- Preferencias Section -->
        <div id="preferencias" class="config-section bg-white rounded-2xl border border-gray-200 p-6 md:p-8 mb-6 hidden lg:block" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-compass text-white"></i>
                </div>
                <div>
                    <h2 class="font-display text-xl font-semibold text-midnight-900">Preferencias</h2>
                    <p class="text-gray-500 text-sm">Personaliza tu experiencia de exploración</p>
                </div>
            </div>
            
            <!-- Vista Predeterminada -->
            <div class="mb-6">
                <label for="default-explore-view" class="block text-sm font-medium text-gray-700 mb-2">Vista predeterminada</label>
                <select id="default-explore-view" data-setting="default-explore-view" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all duration-200">
                    <option value="destacados">Destinos destacados</option>
                    <option value="regiones">Regiones naturales</option>
                    <option value="categorias">Categorías turísticas</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Vista inicial al navegar a Destinos.</p>
            </div>

            <!-- Contenido Destacado -->
            <div class="space-y-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Contenido destacado en Dashboard</h3>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div>
                        <h4 class="font-medium text-midnight-900">Mostrar recomendaciones culturales</h4>
                        <p class="text-sm text-gray-500">Museos, iglesias y patrimonio</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="show-culture" data-setting="show-culture" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div>
                        <h4 class="font-medium text-midnight-900">Mostrar experiencias de naturaleza</h4>
                        <p class="text-sm text-gray-500">Playas, parques y reservas</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="show-nature" data-setting="show-nature" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div>
                        <h4 class="font-medium text-midnight-900">Mostrar gastronomía local</h4>
                        <p class="text-sm text-gray-500">Platos típicos y sabores</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="show-gastronomy" data-setting="show-gastronomy" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                <button type="button" id="btn-reset-preferencias" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-undo mr-2"></i>Restablecer
                </button>
                <button type="button" id="btn-save-preferencias" class="px-6 py-3 bg-gradient-to-r from-[#07111F] to-[#0B1F2A] text-white rounded-xl text-sm font-medium hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-save mr-2"></i>Guardar preferencias
                </button>
            </div>
        </div>

        <!-- Privacidad Section -->
        <div id="privacidad" class="config-section bg-white rounded-2xl border border-gray-200 p-6 md:p-8 mb-6 hidden lg:block" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
                <div>
                    <h2 class="font-display text-xl font-semibold text-midnight-900">Privacidad</h2>
                    <p class="text-gray-500 text-sm">Controla tus datos de navegación</p>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div>
                    <h3 class="font-medium text-midnight-900">Recordar mis preferencias en este dispositivo</h3>
                    <p class="text-sm text-gray-500">Mantén tus ajustes al recargar o cerrar el navegador</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="remember-preferences" data-setting="remember-preferences" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
            
            <div id="privacy-feedback" class="mt-4 text-sm text-emerald-600 hidden">
                <i class="fas fa-check-circle mr-1"></i>
                <span>Preferencias eliminadas de este dispositivo</span>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                <button type="button" id="btn-reset-privacidad" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-undo mr-2"></i>Restablecer
                </button>
                <button type="button" id="btn-save-privacidad" class="px-6 py-3 bg-gradient-to-r from-[#07111F] to-[#0B1F2A] text-white rounded-xl text-sm font-medium hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-save mr-2"></i>Guardar preferencias
                </button>
            </div>
        </div>

        <!-- Apariencia Section -->
        <div id="apariencia" class="config-section bg-white rounded-2xl border border-gray-200 p-6 md:p-8 mb-6 hidden lg:block" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center">
                    <i class="fas fa-palette text-white"></i>
                </div>
                <div>
                    <h2 class="font-display text-xl font-semibold text-midnight-900">Apariencia</h2>
                    <p class="text-gray-500 text-sm">Personaliza la interfaz visual</p>
                </div>
            </div>
            
            <!-- Tema -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Tema</label>
                <div class="flex gap-3">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="theme" value="light" data-setting="theme" checked class="sr-only peer">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all duration-200 text-center">
                            <i class="fas fa-sun text-2xl text-amber-500 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Claro</p>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="theme" value="dark" data-setting="theme" class="sr-only peer">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all duration-200 text-center">
                            <i class="fas fa-moon text-2xl text-indigo-500 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Oscuro</p>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="theme" value="auto" data-setting="theme" class="sr-only peer">
                        <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all duration-200 text-center">
                            <i class="fas fa-adjust text-2xl text-gray-500 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Automático</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Tamaño de Fuente -->
            <div class="mb-6">
                <label for="font-size" class="block text-sm font-medium text-gray-700 mb-2">Tamaño de texto</label>
                <select id="font-size" data-setting="font-size" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all duration-200">
                    <option value="normal">Normal</option>
                    <option value="comfortable">Cómodo</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Aumenta el tamaño de texto para mejor legibilidad.</p>
            </div>

            <!-- Reducir Animaciones -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div>
                    <h3 class="font-medium text-midnight-900">Reducir animaciones</h3>
                    <p class="text-sm text-gray-500">Desactiva efectos decorativos y transiciones</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="reduce-motion" data-setting="reduce-motion" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                <button type="button" id="btn-reset-apariencia" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-undo mr-2"></i>Restablecer
                </button>
                <button type="button" id="btn-save-apariencia" class="px-6 py-3 bg-gradient-to-r from-[#07111F] to-[#0B1F2A] text-white rounded-xl text-sm font-medium hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <i class="fas fa-save mr-2"></i>Guardar preferencias
                </button>
            </div>
        </div>
    </div>
</div>

</div>

<script>
// Mobile tab navigation
document.querySelectorAll('.config-tab-mobile').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.config-tab-mobile').forEach(t => {
            t.classList.remove('active', 'bg-gradient-to-r', 'from-[#07111F]', 'to-[#0B1F2A]', 'text-white', 'shadow-md');
            t.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        });
        
        this.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        this.classList.add('active', 'bg-gradient-to-r', 'from-[#07111F]', 'to-[#0B1F2A]', 'text-white', 'shadow-md');
        
        document.querySelectorAll('.config-section').forEach(section => {
            section.classList.add('hidden');
        });
        
        const targetId = this.getAttribute('data-target');
        document.getElementById(targetId).classList.remove('hidden');
    });
});

// Desktop navigation
document.querySelectorAll('.config-nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        
        document.querySelectorAll('.config-nav-item').forEach(nav => {
            nav.classList.remove('active', 'bg-gradient-to-r', 'from-[#07111F]', 'to-[#0B1F2A]', 'text-white', 'shadow-md');
            nav.classList.add('text-gray-600', 'hover:bg-gray-100');
        });
        
        this.classList.remove('text-gray-600', 'hover:bg-gray-100');
        this.classList.add('active', 'bg-gradient-to-r', 'from-[#07111F]', 'to-[#0B1F2A]', 'text-white', 'shadow-md');
        
        document.querySelectorAll('.config-section').forEach(section => {
            section.classList.add('hidden');
        });
        
        document.getElementById(targetId).classList.remove('hidden');
    });
});
</script>

@endsection
