@extends('layouts.premium')

@section('title', 'Reservas Naturales')

@section('content')
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

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 48px;">
    
    @forelse($items as $item)
    <a href="{{ route('puntos-interes.reservas-naturales.show', $item->id) }}" style="text-decoration: none; color: inherit;">
    <div style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; cursor: pointer; background: white;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'">
        <div style="height: 220px; position: relative; overflow: hidden;">
            @if($item->imagen)
                <img src="{{ $item->imagen }}" alt="{{ $item->nombre }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            @else
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center;">
                    <span style="color: white; font-size: 4rem;">🌲</span>
                </div>
            @endif
            <div style="position: absolute; top: 12px; left: 12px; background: rgba(16, 185, 129, 0.95); backdrop-filter: blur(10px); padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                � Reserva Natural
            </div>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%); padding: 16px; color: white;">
                <div style="display: flex; gap: 16px; font-size: 0.875rem; font-weight: 500;">
                    <span style="display: flex; align-items: center; gap: 4px;">
                        <i class="fas fa-leaf"></i> Biodiversidad
                    </span>
                    <span style="display: flex; align-items: center; gap: 4px;">
                        <i class="fas fa-shield-alt"></i> Protegido
                    </span>
                </div>
            </div>
        </div>
        <div style="padding: 20px;">
            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.3;">
                {{ $item->nombre }}
            </h3>
            <p style="color: #64748b; margin-bottom: 12px; line-height: 1.5; font-size: 0.95rem;">
                {{ Str::limit($item->descripcion, 100) }}
            </p>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.875rem; color: #64748b;">
                <i class="fas fa-map-marker-alt" style="color: #10b981;"></i>
                <span>{{ $item->localidad ?? 'Colombia' }}</span>
            </div>
        </div>
    </div>
    </a>
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
@endsection
