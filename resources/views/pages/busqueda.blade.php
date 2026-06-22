@extends('layouts.premium')

@section('title', 'Buscar') 

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6 md:py-8">

    <!-- Header de búsqueda -->
    <div class="mb-8 md:mb-10">
        <h1 class="font-display text-2xl sm:text-3xl md:text-4xl font-bold text-midnight-900 mb-2">
            Resultados de búsqueda
        </h1>
        @if($query)
            <p class="text-gray-600 text-sm md:text-base">
                {{ $message }}
            </p>
        @endif
    </div>

    <!-- Barra de búsqueda secundaria -->
    <div class="mb-8 md:mb-10">
        <form action="{{ route('buscar') }}" method="GET" class="relative">
            <input 
                type="text" 
                name="q" 
                value="{{ $query ?? '' }}"
                placeholder="Busca destinos, experiencias, lugares o sabores de Colombia"
                class="w-full px-5 py-4 pl-12 rounded-2xl border border-gray-200 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm md:text-base"
            >
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <button 
                type="submit" 
                class="absolute right-3 top-1/2 -translate-y-1/2 px-4 py-2 bg-emerald-500 text-white rounded-xl text-sm font-medium hover:bg-emerald-600 transition-colors"
            >
                Buscar
            </button>
        </form>
    </div>

    @if($hasResults)
        <!-- Resultados agrupados por categoría -->
        @foreach($results as $categoria => $tipos)
            <div class="mb-8 md:mb-10">
                <h2 class="font-display text-xl md:text-2xl font-bold text-midnight-900 mb-4 md:mb-6 flex items-center gap-3">
                    <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                    {{ $categoria }}
                </h2>

                @foreach($tipos as $tipo => $items)
                    <div class="mb-6">
                        <h3 class="text-sm md:text-base font-semibold text-gray-700 mb-3 md:mb-4">{{ $tipo }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-5">
                            @foreach($items as $item)
                                <a href="{{ $item['url'] }}" class="block group">
                                    <div class="bg-white rounded-2xl md:rounded-3xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
                                        @if($item['imagen'])
                                            <div class="relative h-40 md:h-48 overflow-hidden">
                                                <img 
                                                    src="{{ $item['imagen'] }}" 
                                                    alt="{{ $item['nombre'] }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                    loading="lazy"
                                                >
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                                <div class="absolute top-3 left-3">
                                                    <span class="bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-medium text-gray-800">
                                                        {{ $item['tipo'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative h-40 md:h-48 bg-gradient-to-br from-emerald-100 to-blue-100 flex items-center justify-center">
                                                <i class="fas fa-map-marker-alt text-4xl text-emerald-500/50"></i>
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <h4 class="font-display text-base md:text-lg font-bold text-gray-900 mb-1 line-clamp-1">{{ $item['nombre'] }}</h4>
                                            <p class="text-xs md:text-sm text-gray-500 mb-2">{{ $item['ubicacion'] }}</p>
                                            <div class="flex items-center text-emerald-600 text-sm font-medium group-hover:gap-2 transition-all">
                                                Ver detalle <i class="fas fa-arrow-right ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <!-- Estado vacío -->
        <div class="text-center py-16 md:py-24">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-4xl text-gray-400"></i>
            </div>
            <h3 class="font-display text-xl md:text-2xl font-bold text-gray-900 mb-3">
                {{ strlen($query) < 2 ? 'Busca destinos en Colombia' : 'No encontramos resultados' }}
            </h3>
            <p class="text-gray-600 text-sm md:text-base max-w-md mx-auto mb-6">
                {{ $message }}
            </p>
            <div class="flex flex-wrap justify-center gap-2 md:gap-3">
                <a href="{{ route('buscar', ['q' => 'Cartagena']) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-700 transition-colors">
                    Cartagena
                </a>
                <a href="{{ route('buscar', ['q' => 'Medellín']) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-700 transition-colors">
                    Medellín
                </a>
                <a href="{{ route('buscar', ['q' => 'Tayrona']) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-700 transition-colors">
                    Tayrona
                </a>
                <a href="{{ route('buscar', ['q' => 'Museo']) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-700 transition-colors">
                    Museo
                </a>
                <a href="{{ route('buscar', ['q' => 'Playa']) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-700 transition-colors">
                    Playa
                </a>
            </div>
        </div>
    @endif

</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

@endsection
