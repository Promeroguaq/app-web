@php
    $categories = [
        [
            'title' => 'Geográficas',
            'items' => [
                ['label' => 'Departamentos', 'route' => 'departamentos.index', 'icon' => 'fa-map-marker-alt'],
                ['label' => 'Municipios', 'route' => 'municipios.index', 'icon' => 'fa-city'],
                ['label' => 'Capitales', 'route' => 'capitales.index', 'icon' => 'fa-landmark'],
                ['label' => 'Regiones', 'route' => 'regiones', 'icon' => 'fa-globe-americas'],
                ['label' => 'Islas', 'route' => 'puntos-interes.islas', 'icon' => 'fa-water'],
            ]
        ],
        [
            'title' => 'Naturaleza y aventura',
            'items' => [
                ['label' => 'Playas', 'route' => 'puntos-interes.playas', 'icon' => 'fa-umbrella-beach'],
                ['label' => 'Termales', 'route' => 'puntos-interes.termales', 'icon' => 'fa-hot-tub'],
                ['label' => 'Deportes de aventura', 'route' => 'puntos-interes.deportes-aventura', 'icon' => 'fa-hiking'],
                ['label' => 'Ciclismo', 'route' => 'puntos-interes.ciclismo', 'icon' => 'fa-bicycle'],
                ['label' => 'Reservas naturales', 'route' => 'puntos-interes.reservas-naturales', 'icon' => 'fa-tree'],
                ['label' => 'Actividades en parques', 'route' => 'puntos-interes.actividades-parques', 'icon' => 'fa-campground'],
                ['label' => 'Desiertos y lagunas', 'route' => 'puntos-interes.desiertos-lagunas', 'icon' => 'fa-sun'],
            ]
        ],
        [
            'title' => 'Cultura',
            'items' => [
                ['label' => 'Museos', 'route' => 'puntos-interes.museos', 'icon' => 'fa-landmark'],
                ['label' => 'Iglesias', 'route' => 'puntos-interes.iglesias', 'icon' => 'fa-church'],
                ['label' => 'Parques temáticos', 'route' => 'puntos-interes.parques-tematicos', 'icon' => 'fa-ticket-alt'],
                ['label' => 'Fiestas y ferias', 'route' => 'puntos-interes.fiestas-ferias', 'icon' => 'fa-music'],
            ]
        ],
        [
            'title' => 'Sabores y servicios',
            'items' => [
                ['label' => 'Gastronomía', 'route' => 'gastronomia', 'icon' => 'fa-utensils'],
                ['label' => 'Agencias', 'route' => 'agencias', 'icon' => 'fa-briefcase'],
            ]
        ]
    ];
@endphp

<!-- Overlay -->
<div id="categorySheetOverlay" class="fixed inset-0 bg-black/50 z-[60] hidden lg:hidden" onclick="closeCategorySheet()"></div>

<!-- Bottom Sheet -->
<div id="categorySheet" class="fixed bottom-0 left-0 right-0 z-[70] bg-white rounded-t-3xl transform translate-y-full transition-transform duration-300 ease-in-out lg:hidden max-h-[80vh] flex flex-col">
    <!-- Drag Handle -->
    <div class="flex justify-center pt-3 pb-2">
        <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
    </div>

    <!-- Header -->
    <div class="px-6 pb-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Explorar categorías</h2>
        <button onclick="closeCategorySheet()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
            <i class="fas fa-times text-gray-500"></i>
        </button>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-6 py-4" style="padding-bottom: calc(1rem + env(safe-area-inset-bottom, 0px));">
        @foreach($categories as $group)
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">{{ $group['title'] }}</h3>
                <div class="space-y-1">
                    @foreach($group['items'] as $item)
                        @if(Route::has($item['route']))
                        <a href="{{ route($item['route']) }}" 
                           class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group"
                           onclick="closeCategorySheet()">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                    <i class="fas {{ $item['icon'] }}"></i>
                                </div>
                                <span class="font-medium text-gray-900">{{ $item['label'] }}</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600 transition-colors"></i>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function openCategorySheet() {
        const sheet = document.getElementById('categorySheet');
        const overlay = document.getElementById('categorySheetOverlay');
        if (sheet && overlay) {
            sheet.classList.remove('translate-y-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeCategorySheet() {
        const sheet = document.getElementById('categorySheet');
        const overlay = document.getElementById('categorySheetOverlay');
        if (sheet && overlay) {
            sheet.classList.add('translate-y-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCategorySheet();
        }
    });
</script>
