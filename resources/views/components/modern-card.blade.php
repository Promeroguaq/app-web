<!-- Componente de Tarjeta Moderna Reutilizable -->
@props([
    'image' => null,
    'title' => '',
    'description' => '',
    'location' => '',
    'category' => '',
    'rating' => null,
    'badge' => null,
    'price' => null,
    'link' => '#',
    'extra' => null
])

<div class="modern-card w-full max-w-full" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; background: white;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'">
    @if($image)
    <div class="card-image w-full" style="height: 240px; position: relative; overflow: hidden;">
        <img src="{{ $image }}" alt="{{ $title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; max-width: 100%;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">

        @if($badge)
        <div style="position: absolute; top: 12px; left: 12px; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: #1e293b; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            {{ $badge }}
        </div>
        @endif

        @if($rating)
        <div style="position: absolute; bottom: 12px; right: 12px; background: rgba(0,0,0,0.7); backdrop-filter: blur(10px); padding: 6px 10px; border-radius: 8px; color: white; font-size: 0.875rem; font-weight: 600; display: flex; align-items: center; gap: 4px;">
            <span style="color: #fbbf24;">★</span>
            <strong>{{ $rating }}</strong>
        </div>
        @endif

        @if($price)
        <div style="position: absolute; top: 12px; right: 12px; background: rgba(13, 79, 61, 0.9); backdrop-filter: blur(10px); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            {{ $price }}
        </div>
        @endif
    </div>
    @endif

    <div style="padding: 20px;">
        @if($category)
        <div style="display: inline-block; background: rgba(99, 102, 241, 0.1); color: #6366f1; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; margin-bottom: 8px;">
            {{ $category }}
        </div>
        @endif

        <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.3; word-wrap: break-word;">
            {{ $title }}
        </h3>

        @if($description)
        <p style="color: #64748b; margin-bottom: 16px; line-height: 1.5; font-size: 0.95rem;">
            {{ $description }}
        </p>
        @endif

        <div style="display: flex; align-items: center; gap: 16px; font-size: 0.875rem; color: #64748b; margin-bottom: 12px; flex-wrap: wrap;">
            @if($location)
            <span style="display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-map-marker-alt"></i>
                {{ $location }}
            </span>
            @endif
        </div>

        @if($extra)
        <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #e2e8f0;">
            {{ $extra }}
        </div>
        @endif
    </div>
</div>

<style>
@media (max-width: 768px) {
    .modern-card .card-image {
        height: 180px;
    }

    .modern-card h3 {
        font-size: 1.1rem;
    }

    .modern-card p {
        font-size: 0.875rem;
    }
}

@media (max-width: 480px) {
    .modern-card .card-image {
        height: 160px;
    }

    .modern-card {
        border-radius: 12px;
    }

    .modern-card h3 {
        font-size: 1rem;
    }
}
</style>
