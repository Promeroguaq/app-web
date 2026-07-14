@props([
    'title' => 'Descripción',
    'description' => null
])

@if($description)
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[28px] shadow-lg">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 md:mb-4">{{ $title }}</h2>
    <div class="text-sm md:text-base lg:text-lg text-gray-700 leading-relaxed">
        {!! nl2br(e($description)) !!}
    </div>
</div>
@else
<div class="bg-white/80 backdrop-blur-sm p-4 md:p-6 mb-6 md:mb-8 rounded-[20px] md:rounded-[28px] shadow-lg">
    <h2 class="font-display text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-3 md:mb-4">{{ $title }}</h2>
    <div class="text-sm md:text-base lg:text-lg text-gray-500 italic">
        Información turística en actualización.
    </div>
</div>
@endif
