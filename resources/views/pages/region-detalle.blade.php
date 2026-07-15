@extends('layouts.premium')

@section('title', $region->name ?? 'Detalle de Región')

@php
function getDestinationUrl($item, $regionSlug = null) {
    if (!$item) return '/';

    $type = $item->type ?? null;
    $slug = $item->slug ?? null;
    $departmentSlug = $item->departmentSlug ?? null;
    $municipalitySlug = $item->municipalitySlug ?? null;

    // Log para debug
    \Log::info('Destino destacado URL', [
        'name' => $item->name ?? null,
        'type' => $type,
        'slug' => $slug,
        'departmentSlug' => $departmentSlug,
        'municipalitySlug' => $municipalitySlug,
        'regionSlug' => $regionSlug
    ]);

    // Validar que no haya valores undefined o null críticos
    if (!$type) {
        \Log::warning('Destino destacado sin type', ['item' => $item]);
        return '/';
    }

    if ($type === 'department' && $slug) {
        return route('departamentos.show.slug', ['slug' => $slug]);
    }

    if ($type === 'municipality' && $departmentSlug && $slug) {
        return route('municipios.show.slugs', [
            'departmentSlug' => $departmentSlug,
            'municipalitySlug' => $slug
        ]);
    }

    if ($type === 'municipality' && !$departmentSlug) {
        \Log::warning('Destino municipio sin departmentSlug', ['item' => $item]);
        return '/';
    }

    if ($type === 'place') {
        // Si es un lugar, navegar al municipio o departamento relacionado
        if ($municipalitySlug && $departmentSlug) {
            return route('municipios.show.slugs', [
                'departmentSlug' => $departmentSlug,
                'municipalitySlug' => $municipalitySlug
            ]);
        }
        if ($departmentSlug) {
            return route('departamentos.show.slug', ['slug' => $departmentSlug]);
        }
        if ($regionSlug) {
            return '/regiones/' . $regionSlug;
        }
        \Log::warning('Destino place sin slugs válidos', ['item' => $item]);
        return '/';
    }

    if ($type === 'experience') {
        // Para experiencias, hacer scroll a la sección de experiencias
        if ($regionSlug) {
            return '/regiones/' . $regionSlug . '#experiencias';
        }
        return '/';
    }

    return '/';
}
@endphp

@section('content')
<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12 relative overflow-hidden h-[280px] md:h-[320px] lg:h-[360px] @if(isset($region->heroImage) && $region->heroImage) @elseif(isset($region->heroGradient) && $region->heroGradient) @else bg-gradient-to-br from-blue-900 to-blue-700 @endif" @if(isset($region->heroGradient) && $region->heroGradient) style="background: {{ $region->heroGradient }};" @endif>
    @if(isset($region->heroImage) && $region->heroImage)
    <img src="{{ $region->heroImage }}" alt="{{ $region->name }}" class="absolute inset-0 h-full w-full object-cover rounded-[32px]">
    @endif
    @if(isset($region->heroImage) && $region->heroImage)
    <!-- Overlay Layers for Image -->
    <div class="absolute inset-0 rounded-[32px]" style="background: linear-gradient(to right, rgba(15, 23, 42, 0.85) 0%, rgba(30, 58, 138, 0.5) 40%, rgba(30, 58, 138, 0.2) 70%, rgba(30, 58, 138, 0.05) 100%);"></div>
    <div class="absolute inset-0 rounded-[32px] bg-gradient-to-t from-blue-900/50 via-transparent to-transparent"></div>
    @elseif(isset($region->heroGradient) && $region->heroGradient)
    <!-- Overlay for Gradient Fallback -->
    <div class="absolute inset-0 rounded-[32px]" style="background: linear-gradient(to right, rgba(15, 23, 42, 0.6) 0%, rgba(15, 23, 42, 0.3) 50%, rgba(15, 23, 42, 0.1) 100%);"></div>
    <div class="absolute inset-0 rounded-[32px] bg-gradient-to-t from-blue-900/30 via-transparent to-transparent"></div>
    @endif
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="flex flex-wrap gap-3 mb-6">
            <div class="glass-badge">{{ $region->departmentCount ?? 0 }} departamentos</div>
            <div class="glass-badge">{{ $region->climate ?? 'Tropical' }}</div>
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            {{ $region->name }}
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl mb-8" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            {{ data_get($region, 'subtitle', data_get($region, 'description', '')) }}
        </p>
        <div class="flex flex-wrap gap-4">
            <button onclick="scrollToSection('departamentos')" class="px-6 py-3 bg-white text-midnight-900 rounded-full font-semibold hover:shadow-lg transition-all cursor-pointer">
                Ver departamentos
            </button>
            <button onclick="scrollToSection('destinos')" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all cursor-pointer">
                Explorar destinos
            </button>
        </div>
    </div>
</div>

<!-- Summary Section -->
<div class="glass-card p-8 md:p-12 mb-12 rounded-[32px]">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Sobre la Región</h2>
    </div>
    <p class="text-gray-700 text-lg leading-relaxed">
        {{ $region->description ?? 'Sin descripción disponible.' }}
    </p>
</div>

<!-- Departments Section -->
<div id="departamentos" class="mb-12">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Departamentos</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(isset($region->departments) && count($region->departments) > 0)
            @foreach($region->departments as $dept)
            @php
                $deptUrl = route('departamentos.show.slug', ['slug' => $dept->slug]);
            @endphp
            <a href="{{ $deptUrl }}" class="cinematic-card group cursor-pointer rounded-[32px] overflow-hidden hover:-translate-y-2 hover:scale-[1.01] transition-all duration-500" aria-label="Ver departamento {{ $dept->name }}">
                <div class="relative h-48">
                    @if(!empty($dept->image_url))
                        <img src="{{ $dept->image_url }}" alt="{{ $dept->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-white/30 text-4xl"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-all"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="font-display text-xl font-bold mb-1">{{ $dept->name }}</h3>
                        <p class="text-sm opacity-90">Región: {{ $dept->region ?? '' }}</p>
                    </div>
                </div>
                <div class="p-6 bg-white">
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                        <i class="fas fa-city text-[#1D4ED8]"></i>
                        <span>{{ $dept->total_municipios ?? 0 }} municipios</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ data_get($dept, 'description', 'Información turística en actualización.') }}</p>
                    <span class="text-[#1D4ED8] font-semibold text-sm group-hover:translate-x-2 transition-transform inline-flex items-center gap-2">
                        Ver departamento <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
            </a>
            @endforeach
        @else
            <p class="text-gray-600 col-span-3">No hay departamentos disponibles para esta región.</p>
        @endif
    </div>
</div>

<!-- Featured Destinations Section -->
<div id="destinos" class="mb-12">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Destinos Destacados</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(isset($region->featuredDestinations) && count($region->featuredDestinations) > 0)
            @foreach($region->featuredDestinations as $dest)
            @php
                $destUrl = getDestinationUrl($dest, $region->slug ?? null);
            @endphp
            @if($destUrl !== '/')
            <a href="{{ $destUrl }}" class="cinematic-card group cursor-pointer rounded-[32px] overflow-hidden hover:-translate-y-2 hover:scale-[1.01] transition-all duration-500" aria-label="Explorar {{ $dest->name }}">
                <div class="relative h-48 @if(isset($dest->image) && $dest->image) @else bg-gradient-to-br from-blue-600 to-blue-800 @endif">
                    @if(isset($dest->image) && $dest->image)
                    <img src="{{ $dest->image }}" alt="{{ $dest->name }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="font-display text-xl font-bold mb-1">{{ $dest->name }}</h3>
                        <p class="text-sm opacity-90">{{ $dest->description }}</p>
                    </div>
                </div>
            </a>
            @else
            <div class="cinematic-card rounded-[32px] overflow-hidden opacity-50">
                <div class="relative h-48 @if(isset($dest->image) && $dest->image) @else bg-gradient-to-br from-blue-600 to-blue-800 @endif">
                    @if(isset($dest->image) && $dest->image)
                    <img src="{{ $dest->image }}" alt="{{ $dest->name }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="font-display text-xl font-bold mb-1">{{ $dest->name }}</h3>
                        <p class="text-sm opacity-90">{{ $dest->description }}</p>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        @else
            <p class="text-gray-600 col-span-3">No hay destinos destacados disponibles.</p>
        @endif
    </div>
</div>

<!-- Experiences Section -->
<div id="experiencias" class="mb-12">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Experiencias</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(isset($region->experiences) && count($region->experiences) > 0)
            @foreach($region->experiences as $exp)
            <div class="cinematic-card rounded-[32px] overflow-hidden">
                <div class="relative h-48 @if(isset($exp->image) && $exp->image) @else bg-gradient-to-br from-[#1D4ED8] to-[#1E40AF] @endif">
                    @if(isset($exp->image) && $exp->image)
                    <img src="{{ $exp->image }}" alt="{{ $exp->title }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="font-display text-xl font-bold mb-1">{{ $exp->title }}</h3>
                        <p class="text-sm opacity-90">{{ $exp->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <p class="text-gray-600 col-span-3">No hay experiencias disponibles.</p>
        @endif
    </div>
</div>

<!-- Gallery Section -->
<div class="mb-12">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Galería</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if(isset($region->gallery) && count($region->gallery) > 0)
            @foreach($region->gallery as $image)
            <div class="cinematic-card rounded-[32px] overflow-hidden aspect-square">
                <img src="{{ $image }}" alt="Galería" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
            </div>
            @endforeach
        @else
            <p class="text-gray-600 col-span-3">No hay imágenes disponibles.</p>
        @endif
    </div>
</div>

<!-- Map Section -->
<div class="glass-card p-8 md:p-12 mb-12 rounded-[32px] bg-gradient-to-br from-midnight-900 to-midnight-800 text-white">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold">Ubicación</h2>
    </div>
    <div class="text-center py-12">
        <i class="fas fa-map-marked-alt text-6xl text-[#1D4ED8] mb-6"></i>
        <h3 class="font-display text-2xl font-bold mb-2">Ubicación de {{ $region->name }}</h3>
        <p class="text-gray-300 mb-8">Explora los departamentos de esta región</p>
        <a href="#departamentos" class="px-6 py-3 bg-[#1D4ED8] text-white rounded-full font-semibold hover:bg-[#1E40AF] transition-all">
            Ver departamentos
        </a>
    </div>
</div>

<!-- CTA Section -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora los departamentos de {{ $region->name }}</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
        Descubre la diversidad cultural, natural y turística de esta región
    </p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/departamentos" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            Ver todos los departamentos
        </a>
        <a href="/regiones" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Descubre más regiones
        </a>
    </div>
</div>

</div>

<script>
function scrollToSection(sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>

@endsection
