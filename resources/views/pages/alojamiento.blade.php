@extends('layouts.premium')

@section('title', 'Agencias')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section - Airbnb Style -->
<div class="hero-section rounded-[32px] mb-12" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%);">
    <div class="hero-overlay rounded-[32px]"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 text-white">
        <div class="glass-badge inline-block mb-6">
            🏨 Tu Hogar en Colombia
        </div>
        <h1 class="font-display text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
            Agencias de Viajes
        </h1>
        <p class="text-lg md:text-xl opacity-90 max-w-2xl" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
            Encuentra el lugar perfecto para tu estancia, desde hoteles de lujo hasta ecolodges naturales
        </p>
    </div>
</div>

<!-- Premium Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-pink-600 mb-2">500+</div>
        <div class="text-sm text-gray-600 font-medium">Hoteles</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-pink-600 mb-2">32</div>
        <div class="text-sm text-gray-600 font-medium">Departamentos</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-pink-600 mb-2">4.8</div>
        <div class="text-sm text-gray-600 font-medium">Calificación</div>
    </div>
    <div class="glass-card p-6 text-center rounded-[32px]">
        <div class="text-3xl md:text-4xl font-bold text-pink-600 mb-2">24/7</div>
        <div class="text-sm text-gray-600 font-medium">Atención</div>
    </div>
</div>

<!-- Airbnb-Style Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
    
    <!-- Hotel -->
    <div class="cinematic-card group cursor-pointer bg-white">
        <div class="relative h-72 overflow-hidden" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #4338ca 100%);">
            <div class="absolute top-4 right-4 glass-badge">
                <i class="fas fa-heart"></i>
            </div>
            <div class="absolute top-4 left-4 glass-badge bg-pink-500/30">
                🏨 Hotel
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-display text-xl font-bold text-midnight-900">Hotel Hilton Cartagena</h3>
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="font-semibold">5.0</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm mb-3">Cartagena, Bolívar</p>
            <p class="text-gray-600 text-sm mb-4">Lujo y confort en el corazón de Cartagena con vistas al mar</p>
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                <span><i class="fas fa-wifi mr-1"></i> WiFi</span>
                <span><i class="fas fa-swimming-pool mr-1"></i> Piscina</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-pink-600">$250<span class="text-sm font-normal text-gray-500">/noche</span></div>
                <button class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    Reservar
                </button>
            </div>
        </div>
    </div>

    <!-- Hostal -->
    <div class="cinematic-card group cursor-pointer bg-white">
        <div class="relative h-72 overflow-hidden" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);">
            <div class="absolute top-4 right-4 glass-badge">
                <i class="fas fa-heart"></i>
            </div>
            <div class="absolute top-4 left-4 glass-badge bg-pink-500/30">
                🏠 Hostal
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-display text-xl font-bold text-midnight-900">Hostal Media Luna</h3>
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="font-semibold">4.5</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm mb-3">Cartagena, Bolívar</p>
            <p class="text-gray-600 text-sm mb-4">Ambiente bohemio en el centro histórico de Cartagena</p>
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                <span><i class="fas fa-utensils mr-1"></i> Cocina</span>
                <span><i class="fas fa-wifi mr-1"></i> WiFi</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-pink-600">$45<span class="text-sm font-normal text-gray-500">/noche</span></div>
                <button class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    Reservar
                </button>
            </div>
        </div>
    </div>

    <!-- Resort -->
    <div class="cinematic-card group cursor-pointer bg-white">
        <div class="relative h-72 overflow-hidden" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);">
            <div class="absolute top-4 right-4 glass-badge">
                <i class="fas fa-heart"></i>
            </div>
            <div class="absolute top-4 left-4 glass-badge bg-pink-500/30">
                🏖️ Resort
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-display text-xl font-bold text-midnight-900">Decameron San Andrés</h3>
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="font-semibold">5.0</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm mb-3">San Andrés, Providencia</p>
            <p class="text-gray-600 text-sm mb-4">Todo incluido en paraíso caribeño con playa privada</p>
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                <span><i class="fas fa-umbrella-beach mr-1"></i> Playa</span>
                <span><i class="fas fa-cocktail mr-1"></i> Bar</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-pink-600">$320<span class="text-sm font-normal text-gray-500">/noche</span></div>
                <button class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    Reservar
                </button>
            </div>
        </div>
    </div>

    <!-- Hotel -->
    <div class="cinematic-card group cursor-pointer bg-white">
        <div class="relative h-72 overflow-hidden" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);">
            <div class="absolute top-4 right-4 glass-badge">
                <i class="fas fa-heart"></i>
            </div>
            <div class="absolute top-4 left-4 glass-badge bg-pink-500/30">
                🏪 Hotel
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-display text-xl font-bold text-midnight-900">Hotel Dann Santa Marta</h3>
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="font-semibold">4.5</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm mb-3">Santa Marta, Magdalena</p>
            <p class="text-gray-600 text-sm mb-4">Confort y excelente ubicación en Santa Marta</p>
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                <span><i class="fas fa-concierge-bell mr-1"></i> Servicio</span>
                <span><i class="fas fa-wifi mr-1"></i> WiFi</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-pink-600">$180<span class="text-sm font-normal text-gray-500">/noche</span></div>
                <button class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    Reservar
                </button>
            </div>
        </div>
    </div>

    <!-- Casa -->
    <div class="cinematic-card group cursor-pointer bg-white">
        <div class="relative h-72 overflow-hidden" style="background: linear-gradient(135deg, #92400e 0%, #78350f 50%, #451a03 100%);">
            <div class="absolute top-4 right-4 glass-badge">
                <i class="fas fa-heart"></i>
            </div>
            <div class="absolute top-4 left-4 glass-badge bg-pink-500/30">
                🏡 Casa
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-display text-xl font-bold text-midnight-900">Casa Cafetera Salento</h3>
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="font-semibold">5.0</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm mb-3">Salento, Quindío</p>
            <p class="text-gray-600 text-sm mb-4">Acolchillada tradicional con vistas al valle de Cocora</p>
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                <span><i class="fas fa-fire mr-1"></i> Chimenea</span>
                <span><i class="fas fa-mountain mr-1"></i> Montaña</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-pink-600">$95<span class="text-sm font-normal text-gray-500">/noche</span></div>
                <button class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    Reservar
                </button>
            </div>
        </div>
    </div>

    <!-- Ecolodge -->
    <div class="cinematic-card group cursor-pointer bg-white">
        <div class="relative h-72 overflow-hidden" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);">
            <div class="absolute top-4 right-4 glass-badge">
                <i class="fas fa-heart"></i>
            </div>
            <div class="absolute top-4 left-4 glass-badge bg-pink-500/30">
                🌿 Ecolodge
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-display text-xl font-bold text-midnight-900">Ecolodge Tayrona</h3>
                <div class="flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="font-semibold">4.5</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm mb-3">Santa Marta, Magdalena</p>
            <p class="text-gray-600 text-sm mb-4">Alojamiento ecológico dentro del Parque Tayrona</p>
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                <span><i class="fas fa-leaf mr-1"></i> Ecológico</span>
                <span><i class="fas fa-hiking mr-1"></i> Senderismo</span>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-pink-600">$120<span class="text-sm font-normal text-gray-500">/noche</span></div>
                <button class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    Reservar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="glass-card p-12 text-center bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-[32px]">
    <h2 class="font-display text-3xl font-bold mb-4">Explora Más Destinos</h2>
    <p class="text-lg opacity-90 mb-8 max-w-2xl mx-auto">Descubre otras categorías de turismo en Colombia</p>
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="/departamentos" class="px-6 py-3 bg-white text-pink-600 rounded-full font-semibold hover:shadow-lg transition-all">
            🗺️ Destinos
        </a>
        <a href="/gastronomia" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🍽️ Gastronomía
        </a>
        <a href="/eventos" class="px-6 py-3 bg-white/20 text-white rounded-full font-semibold hover:bg-white/30 transition-all">
            🎉 Eventos
        </a>
    </div>
</div>

</div>
@endsection
