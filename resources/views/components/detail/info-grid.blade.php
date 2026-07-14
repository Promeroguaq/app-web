@props([
    'items' => []
])

@if(!empty($items))
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[28px] shadow-lg">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
        @foreach($items as $item)
            @if(isset($item['label']) && isset($item['value']) && !empty($item['value']))
            <div class="flex items-center gap-3 md:gap-4 p-3 md:p-4 bg-white/50 rounded-2xl">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $item['icon'] ?? 'fa-info-circle' }} text-white text-lg md:text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] md:text-xs text-gray-500 font-medium">{{ $item['label'] }}</div>
                    <div class="font-bold text-gray-900 text-sm md:text-base">{{ $item['value'] }}</div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endif
