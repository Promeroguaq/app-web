@extends('layouts.premium')

@section('title', 'Reservas Naturales')

@section('content')
<!-- Main Container -->
<div class="w-full max-w-7xl mx-auto overflow-x-hidden">

<!-- Hero Section -->
<div style="height: 350px; border-radius: 20px; overflow: hidden; position: relative; margin-bottom: 48px; box-shadow: 0 20px 40px rgba(0,0,0,0.15); background: linear-gradient(135deg, #064e3b 0%, #10b981 50%, #059669 100%);">
    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 48px; color: white;">
        <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: white; display: inline-block; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            🌴 Naturaleza
        </div>
        <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 3rem; font-weight: 800; margin-bottom: 12px; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Reservas Naturales</h1>
        <p style="font-size: 1.25rem; opacity: 0.9;">Protege y explora la biodiversidad de Colombia</p>
    </div>
</div>

<!-- Estadísticas -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 48px;">
    <div style="background: white; padding: 24px; border-radius: 16px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #10b981; font-family: 'Space Grotesk', sans-serif; margin-bottom: 8px;">{{ $items->count() }}</div>
        <div style="color: #64748b; font-size: 0.9rem;">Áreas Protegidas</div>
    </div>
    <div style="background: white; padding: 24px; border-radius: 16px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #10b981; font-family: 'Space Grotesk', sans-serif; margin-bottom: 8px;">15%</div>
        <div style="color: #64748b; font-size: 0.9rem;">Territorio Nacional</div>
    </div>
    <div style="background: white; padding: 24px; border-radius: 16px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #10b981; font-family: 'Space Grotesk', sans-serif; margin-bottom: 8px;">52K</div>
        <div style="color: #64748b; font-size: 0.9rem;">Especies</div>
    </div>
    <div style="background: white; padding: 24px; border-radius: 16px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div style="font-size: 2.5rem; font-weight: 800; color: #10b981; font-family: 'Space Grotesk', sans-serif; margin-bottom: 8px;">#1</div>
        <div style="color: #64748b; font-size: 0.9rem;">En Biodiversidad</div>
    </div>
</div>

<!-- Reservas Destacadas -->
<h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 2rem; font-weight: 700; color: #1e293b; margin-bottom: 32px; text-align: center;">Reservas Destacadas</h2>

@if(isset($error))
<div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #ef4444; background: #fef2f2; border-radius: 16px; margin-bottom: 24px;">
    <strong>Error:</strong> {{ $error }}
</div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-12">
    
    @forelse($items as $item)
    <x-cards.tourism-card
        :id="$item->id"
        :title="$item->nombre"
        :description="$item->descripcion ?? 'Información turística en actualización.'"
        :image="$item->imagen"
        :badge="'🌲 Reserva Natural'"
        :location="$item->localidad"
        :secondaryLocation="$item->departamento"
        :detailUrl="route('puntos-interes.reservas-naturales.show', ['id' => $item->id])"
        :fallbackTheme="'nature'"
    />
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
        No hay reservas naturales registradas en este momento.
    </div>
    @endforelse

</div>

<!-- Explorar Más -->
<div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 20px; padding: 48px; text-align: center; color: white; box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);">
    <h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 2rem; font-weight: 700; margin-bottom: 16px;">Explora Más Destinos</h2>
    <p style="margin-bottom: 32px; opacity: 0.9; font-size: 1.1rem;">Descubre otras categorías de naturaleza en Colombia</p>
    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <button style="background: white; color: #10b981; padding: 12px 24px; border: none; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            🏖️ Playas
        </button>
        <button style="background: rgba(255,255,255,0.2); color: white; padding: 12px 24px; border: 2px solid rgba(255,255,255,0.3); border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
            🏝️ Islas
        </button>
        <button style="background: rgba(255,255,255,0.2); color: white; padding: 12px 24px; border: 2px solid rgba(255,255,255,0.3); border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
            🌡️ Termales
        </button>
    </div>
</div>

<!-- Padding bottom para navegación móvil -->
<div class="h-20 md:h-0"></div>

</div>
@endsection
