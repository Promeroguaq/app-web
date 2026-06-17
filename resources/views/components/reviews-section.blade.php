@props([
    'reviewableType' => null,
    'reviewableId' => null,
    'reviews' => null,
    'averageRating' => 0,
    'reviewsCount' => 0,
])

<!-- Reviews Section -->
<div class="mt-12 md:mt-16 mb-8">
    <div class="flex items-center gap-3 mb-6 md:mb-8">
        <div class="w-1 h-8 bg-gradient-to-b from-[#ec4899] to-[#be185d] rounded-full"></div>
        <h2 class="font-display text-2xl md:text-3xl font-bold text-midnight-900">Opiniones de viajeros</h2>
    </div>

    <p class="text-gray-600 mb-8 md:mb-10 text-sm md:text-base">
        Comparte tu experiencia y ayuda a otros viajeros a descubrir este destino.
    </p>

    <!-- Rating Summary -->
    @if($reviewsCount > 0)
    <div class="glass-card p-6 md:p-8 rounded-[32px] mb-8 md:mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="text-5xl md:text-6xl font-bold text-[#ec4899]">
                    {{ number_format($averageRating, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-1 mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($averageRating))
                                <i class="fas fa-star text-[#ec4899] text-lg"></i>
                            @elseif($i - 0.5 <= $averageRating)
                                <i class="fas fa-star-half-alt text-[#ec4899] text-lg"></i>
                            @else
                                <i class="far fa-star text-gray-300 text-lg"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ $reviewsCount }} {{ $reviewsCount == 1 ? 'opinión' : 'opiniones' }}
                    </div>
                </div>
            </div>
            <div class="text-sm text-gray-500">
                Basado en reseñas verificadas
            </div>
        </div>
    </div>
    @else
    <div class="glass-card p-6 md:p-8 rounded-[32px] mb-8 md:mb-10 text-center">
        <div class="text-4xl md:text-5xl mb-3 md:mb-4">⭐</div>
        <p class="text-gray-600 text-sm md:text-base">Sin calificaciones aún</p>
        <p class="text-gray-500 text-xs md:text-sm mt-2">Sé el primero en dejar una opinión</p>
    </div>
    @endif

    <!-- Reviews List -->
    @if($reviews && $reviews->count() > 0)
    <div class="space-y-4 md:space-y-6 mb-8 md:mb-10">
        @foreach($reviews as $review)
        <div class="glass-card p-5 md:p-6 rounded-[20px] md:rounded-[32px]">
            <div class="flex items-start justify-between mb-3 md:mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-br from-[#ec4899] to-[#be185d] flex items-center justify-center text-white font-bold text-sm md:text-base">
                        {{ strtoupper(substr($review->guest_name ?? ($review->user ? $review->user->name : 'A') , 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm md:text-base">
                            {{ $review->guest_name ?? ($review->user ? $review->user->name : 'Viajero') }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $review->created_at ? $review->created_at->format('d M Y') : '' }}
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star text-[#ec4899] text-xs md:text-sm"></i>
                        @else
                            <i class="far fa-star text-gray-300 text-xs md:text-sm"></i>
                        @endif
                    @endfor
                </div>
            </div>
            <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                {{ $review->comment }}
            </p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Review Form -->
    <div class="glass-card p-6 md:p-8 rounded-[20px] md:rounded-[32px]">
        <h3 class="font-display text-xl md:text-2xl font-bold text-midnight-900 mb-4 md:mb-6">Deja tu opinión</h3>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 md:mb-6 text-sm md:text-base">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 md:mb-6 text-sm md:text-base">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 md:mb-6 text-sm md:text-base">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf

            <input type="hidden" name="reviewable_type" value="{{ $reviewableType }}">
            <input type="hidden" name="reviewable_id" value="{{ $reviewableId }}">

            @if(!auth()->check())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-4 md:mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                    <input type="text" name="guest_name" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#ec4899] focus:ring-2 focus:ring-[#ec4899]/20 outline-none transition-all text-sm md:text-base"
                        placeholder="Tu nombre"
                        value="{{ old('guest_name') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email (opcional)</label>
                    <input type="email" name="guest_email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#ec4899] focus:ring-2 focus:ring-[#ec4899]/20 outline-none transition-all text-sm md:text-base"
                        placeholder="tu@email.com"
                        value="{{ old('guest_email') }}">
                </div>
            </div>
            @endif

            <div class="mb-4 md:mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Calificación *</label>
                <div class="flex items-center gap-2">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" 
                        class="star-btn text-2xl md:text-3xl transition-all hover:scale-110 focus:outline-none"
                        data-rating="{{ $i }}">
                        <i class="far fa-star text-gray-300 hover:text-[#ec4899]"></i>
                    </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" required>
            </div>

            <div class="mb-4 md:mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Comentario *</label>
                <textarea name="comment" rows="4" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#ec4899] focus:ring-2 focus:ring-[#ec4899]/20 outline-none transition-all resize-none text-sm md:text-base"
                    placeholder="Comparte tu experiencia... (mínimo 10 caracteres)"
                    maxlength="1000">{{ old('comment') }}</textarea>
                <div class="text-xs text-gray-500 mt-1 text-right">
                    <span id="char-count">0</span>/1000
                </div>
            </div>

            <button type="submit"
                class="w-full md:w-auto px-8 py-3 md:py-4 bg-gradient-to-r from-[#ec4899] to-[#be185d] text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-[#ec4899]/30 transition-all text-sm md:text-base">
                Publicar opinión
            </button>

            <p class="text-xs text-gray-500 mt-3 md:mt-4">
                <i class="fas fa-info-circle mr-1"></i>
                Tu comentario será revisado antes de publicarse.
            </p>
        </form>
    </div>
</div>

<script>
function setRating(rating) {
    document.getElementById('rating-input').value = rating;
    const starBtns = document.querySelectorAll('.star-btn');
    starBtns.forEach((btn, index) => {
        const btnRating = parseInt(btn.dataset.rating);
        const icon = btn.querySelector('i');
        if (btnRating <= rating) {
            icon.classList.remove('far', 'text-gray-300');
            icon.classList.add('fas', 'text-[#ec4899]');
        } else {
            icon.classList.remove('fas', 'text-[#ec4899]');
            icon.classList.add('far', 'text-gray-300');
        }
    });
}

// Character counter
const commentTextarea = document.querySelector('textarea[name="comment"]');
const charCount = document.getElementById('char-count');
if (commentTextarea && charCount) {
    commentTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
}
</script>
