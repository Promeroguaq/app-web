@extends('layouts.premium')

@section('title', 'Regiones Naturales')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1d4ed8 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            Geografía
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Regiones de Colombia
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Explora las 6 regiones naturales del país
        </p>
    </div>
</div>

<!-- Stats Section -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">6</div>
        <div class="text-sm text-gray-600">Regiones</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">32</div>
        <div class="text-sm text-gray-600">Departamentos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">1.1M</div>
        <div class="text-sm text-gray-600">km²</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-4xl font-bold text-[#1D4ED8] mb-2">100%</div>
        <div class="text-sm text-gray-600">Diversidad</div>
    </div>
</div>

<!-- Regions Grid -->
<div class="flex items-center gap-3 mb-8">
    <div class="w-1 h-8 bg-gradient-to-b from-[#1D4ED8] to-[#1E40AF] rounded-full"></div>
    <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Regiones Naturales</h2>
</div>

@php
$regionImages = [];
$regionImages[] = \App\Helpers\ImageHelper::getRandomImageByCategory('playas');
$regionImages[] = \App\Helpers\ImageHelper::getRandomImageByCategory('turismo_cultural', $regionImages);
$regionImages[] = \App\Helpers\ImageHelper::getRandomImageByCategory('turismo_naturaleza', $regionImages);
$regionImages[] = \App\Helpers\ImageHelper::getRandomImageByCategory('turismo_naturaleza', $regionImages);
$regionImages[] = \App\Helpers\ImageHelper::getRandomImageByCategory('turismo_naturaleza', $regionImages);
$regionImages[] = \App\Helpers\ImageHelper::getRandomImageByCategory('islas', $regionImages);
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">

    <!-- Caribe -->
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="/regiones/caribe" class="block">
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);">
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    🌴 Caribe
                </div>
                <div class="absolute top-3 right-3 md:top-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-medium text-white z-10">
                    7 deptos
                </div>
            </div>
            <div class="p-4 md:p-6 bg-white">
                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2">Región Caribe</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">Playas paradisíacas, cultura caribeña y gastronomía única</p>
                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                    <a href="/departamentos/la-guajira" class="px-2 py-1 md:px-3 md:py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-amber-200 transition-colors">La Guajira</a>
                    <a href="/departamentos/magdalena" class="px-2 py-1 md:px-3 md:py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-amber-200 transition-colors">Magdalena</a>
                    <span class="px-2 py-1 md:px-3 md:py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] md:text-xs font-medium">+5</span>
                </div>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <span class="text-amber-600 font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Explorar región <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>

    <!-- Andina -->
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="/regiones/andina" class="block">
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);">
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    ⛰️ Andina
                </div>
                <div class="absolute top-3 right-3 md:top-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-medium text-white z-10">
                    9 deptos
                </div>
            </div>
            <div class="p-4 md:p-6 bg-white">
                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2">Región Andina</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">Montañas, valles y el corazón cultural de Colombia</p>
                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                    <a href="/departamentos/antioquia" class="px-2 py-1 md:px-3 md:py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-blue-200 transition-colors">Antioquia</a>
                    <a href="/departamentos/cundinamarca" class="px-2 py-1 md:px-3 md:py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-blue-200 transition-colors">Cundinamarca</a>
                    <span class="px-2 py-1 md:px-3 md:py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] md:text-xs font-medium">+7</span>
                </div>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <span class="text-blue-600 font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Explorar región <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>

    <!-- Pacífica -->
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="/regiones/pacifica" class="block">
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);">
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    🌊 Pacífica
                </div>
                <div class="absolute top-3 right-3 md:top-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-medium text-white z-10">
                    4 deptos
                </div>
            </div>
            <div class="p-4 md:p-6 bg-white">
                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2">Región Pacífica</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">Bosques húmedos, ballenas jorobadas y biodiversidad</p>
                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                    <a href="/departamentos/choco" class="px-2 py-1 md:px-3 md:py-1 bg-cyan-100 text-cyan-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-cyan-200 transition-colors">Chocó</a>
                    <a href="/departamentos/valle-del-cauca" class="px-2 py-1 md:px-3 md:py-1 bg-cyan-100 text-cyan-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-cyan-200 transition-colors">Valle</a>
                    <span class="px-2 py-1 md:px-3 md:py-1 bg-cyan-100 text-cyan-700 rounded-full text-[10px] md:text-xs font-medium">+2</span>
                </div>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <span class="text-cyan-600 font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Explorar región <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>

    <!-- Amazonía -->
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="/regiones/amazonia" class="block">
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" style="background: linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%);">
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    🌿 Amazonía
                </div>
                <div class="absolute top-3 right-3 md:top-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-medium text-white z-10">
                    2 deptos
                </div>
            </div>
            <div class="p-4 md:p-6 bg-white">
                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2">Región Amazonía</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">Selva tropical, ríos caudalosos y naturaleza virgen</p>
                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                    <a href="/departamentos/amazonas" class="px-2 py-1 md:px-3 md:py-1 bg-[#1D4ED8]/10 text-[#1D4ED8] rounded-full text-[10px] md:text-xs font-medium hover:bg-[#1D4ED8]/20 transition-colors">Amazonas</a>
                    <a href="/departamentos/vaupes" class="px-2 py-1 md:px-3 md:py-1 bg-[#1D4ED8]/10 text-[#1D4ED8] rounded-full text-[10px] md:text-xs font-medium hover:bg-[#1D4ED8]/20 transition-colors">Vaupés</a>
                </div>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <span class="text-[#1D4ED8] font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Explorar región <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>

    <!-- Llanos -->
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="/regiones/llanos" class="block">
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" style="background: linear-gradient(135deg, #84cc16 0%, #65a30d 50%, #4d7c0f 100%);">
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    🌾 Llanos
                </div>
                <div class="absolute top-3 right-3 md:top-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-medium text-white z-10">
                    4 deptos
                </div>
            </div>
            <div class="p-4 md:p-6 bg-white">
                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2">Región Llanos</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">Sabanas infinitas, ganadería y cultura llanera</p>
                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                    <a href="/departamentos/meta" class="px-2 py-1 md:px-3 md:py-1 bg-lime-100 text-lime-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-lime-200 transition-colors">Meta</a>
                    <a href="/departamentos/casanare" class="px-2 py-1 md:px-3 md:py-1 bg-lime-100 text-lime-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-lime-200 transition-colors">Casanare</a>
                    <span class="px-2 py-1 md:px-3 md:py-1 bg-lime-100 text-lime-700 rounded-full text-[10px] md:text-xs font-medium">+2</span>
                </div>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <span class="text-lime-600 font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Explorar región <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>

    <!-- Insular -->
    <div class="rounded-[20px] md:rounded-[32px] overflow-hidden bg-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full">
        <a href="/regiones/insular" class="block">
            <div class="relative h-48 sm:h-56 md:h-64 overflow-hidden w-full" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%);">
                <div class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-sm px-3 py-1 md:px-4 md:py-2 rounded-full text-xs md:text-sm font-semibold text-gray-800 shadow-md z-10">
                    🏝️ Insular
                </div>
                <div class="absolute top-3 right-3 md:top-4 md:right-4 bg-black/50 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-medium text-white z-10">
                    2 deptos
                </div>
            </div>
            <div class="p-4 md:p-6 bg-white">
                <h3 class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900 mb-2">Región Insular</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 line-clamp-2">Islas caribeñas, arrecifes de coral y paraíso tropical</p>
                <div class="flex flex-wrap gap-2 mb-3 md:mb-4">
                    <a href="/departamentos/san-andres-providencia" class="px-2 py-1 md:px-3 md:py-1 bg-violet-100 text-violet-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-violet-200 transition-colors">San Andrés</a>
                    <a href="/departamentos/san-andres-providencia" class="px-2 py-1 md:px-3 md:py-1 bg-violet-100 text-violet-700 rounded-full text-[10px] md:text-xs font-medium hover:bg-violet-200 transition-colors">Providencia</a>
                </div>
                <div class="flex items-center justify-between pt-2 md:pt-3 border-t border-gray-200">
                    <span class="text-violet-600 font-semibold text-xs md:text-sm flex items-center gap-2 hover:gap-3 transition-all">
                        Explorar región <i class="fas fa-arrow-right text-xs md:text-sm"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- CTA Section -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-[#1D4ED8] to-[#1E40AF] text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Destinos</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
        Descubre los departamentos de cada región
    </p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/departamentos" class="px-6 py-3 bg-white text-[#1D4ED8] rounded-full font-semibold hover:shadow-lg transition-all">
            Departamentos
        </a>
        <a href="/playas" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Playas
        </a>
        <a href="/destinos" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            Reservas Naturales
        </a>
    </div>
</div>

</div>
@endsection
