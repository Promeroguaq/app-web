@props([
    'title' => '',
    'items' => [],
    'viewAllRoute' => null,
    'viewAllText' => 'Ver todos',
    'id' => null,
    'itemsPerView' => [
        'mobile' => 1.5,
        'tablet' => 2,
        'desktop' => 4
    ]
])

@php
    $carouselId = $id ?? 'carousel-' . uniqid();
    $hasMoreItems = count($items) > ($itemsPerView['desktop'] ?? 4);
@endphp

<div class="mb-8 md:mb-12" id="{{ $carouselId }}-container">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4 md:mb-6">
        <h2 class="font-display text-xl sm:text-2xl md:text-3xl font-bold text-midnight-900">{{ $title }}</h2>
        
        <div class="flex items-center gap-3">
            @if($viewAllRoute)
                <a href="{{ $viewAllRoute }}" class="text-sm md:text-base font-medium text-gray-600 hover:text-midnight-900 transition-colors">
                    {{ $viewAllText }}
                </a>
            @endif
            
            @if($hasMoreItems)
                <div class="flex items-center gap-2">
                    <button 
                        class="carousel-prev-btn w-10 h-10 md:w-12 md:h-12 rounded-full bg-white border border-gray-200 shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-300 flex items-center justify-center text-gray-700 hover:text-midnight-900 disabled:opacity-40 disabled:cursor-not-allowed"
                        data-carousel="{{ $carouselId }}"
                        aria-label="Ver elementos anteriores de {{ $title }}"
                        disabled
                    >
                        <i class="fas fa-chevron-left text-sm md:text-base"></i>
                    </button>
                    <button 
                        class="carousel-next-btn w-10 h-10 md:w-12 md:h-12 rounded-full bg-white border border-gray-200 shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-300 flex items-center justify-center text-gray-700 hover:text-midnight-900 disabled:opacity-40 disabled:cursor-not-allowed"
                        data-carousel="{{ $carouselId }}"
                        aria-label="Ver más elementos de {{ $title }}"
                    >
                        <i class="fas fa-chevron-right text-sm md:text-base"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Carousel Container -->
    <div class="relative">
        <div 
            id="{{ $carouselId }}"
            class="carousel-track flex gap-4 md:gap-6 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory scroll-smooth"
            data-items-per-view-mobile="{{ $itemsPerView['mobile'] }}"
            data-items-per-view-tablet="{{ $itemsPerView['tablet'] }}"
            data-items-per-view-desktop="{{ $itemsPerView['desktop'] }}"
        >
            {{ $slot }}
        </div>

        <!-- Progress Bar (Mobile) -->
        @if($hasMoreItems)
            <div class="md:hidden mt-3 h-1 bg-gray-200 rounded-full overflow-hidden">
                <div class="carousel-progress h-full bg-midnight-900 transition-all duration-300" style="width: 0%"></div>
            </div>
        @endif
    </div>
</div>
