@extends('layouts.premium')

@section('title', 'Agencias de Viaje')

@section('content')
<!-- Hero Section -->
<div style="height: 300px; border-radius: 20px; overflow: hidden; position: relative; margin-bottom: 48px; box-shadow: 0 20px 40px rgba(0,0,0,0.15); background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%);">
    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 48px; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); color: white;">
        <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 3rem; font-weight: 800; margin-bottom: 12px; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Agencias de Viaje</h1>
        <p style="font-size: 1.25rem; opacity: 0.9;">Encuentra las mejores agencias turísticas de Colombia</p>
    </div>
</div>

<!-- Filtros por Tipo -->
<div style="background: white; padding: 24px; border-radius: 20px; margin-bottom: 48px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
    <div style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center;">
        <button style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white; padding: 10px 20px; border: none; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem;">Todas</button>
        <button style="background: white; color: #64748b; padding: 10px 20px; border: 2px solid #e2e8f0; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#6366f1'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">🇨🇴 Nacionales</button>
        <button style="background: white; color: #64748b; padding: 10px 20px; border: 2px solid #e2e8f0; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#6366f1'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">🌍 Internacionales</button>
        <button style="background: white; color: #64748b; padding: 10px 20px; border: 2px solid #e2e8f0; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#6366f1'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">🌿 Ecoturismo</button>
        <button style="background: white; color: #64748b; padding: 10px 20px; border: 2px solid #e2e8f0; border-radius: 25px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#6366f1'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">🧗 Aventura</button>
    </div>
</div>

<!-- Agencias Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 48px;">
    
    <!-- Agencia 1 -->
    <div style="border-radius: 20px; border: none; box-shadow: 0 8px 32px rgba(0,0,0,0.12); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; background: white; position: relative;" onmouseover="this.style.transform='translateY(-12px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.18)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'">
        <div style="position: relative; height: 200px; overflow: hidden; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);">
            <div style="position: absolute; bottom: -20px; left: 20px; width: 60px; height: 60px; border-radius: 50%; background: white; border: 4px solid white; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 2;">
                <i class="fas fa-plane" style="color: #6366f1;"></i>
            </div>
        </div>
        
        <div style="padding: 32px 24px 24px;">
            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 12px; line-height: 1.2;">Colombia Travel</h3>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <div style="color: #f59e0b; font-size: 16px;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; color: #374151;">4.8</span>
            </div>
            <p style="font-family: 'Plus Jakarta Sans', sans-serif; color: #4b5563; font-size: 0.875rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px;">
                Especialistas en turismo nacional con más de 15 años de experiencia. Ofrecemos paquetes completos a los destinos más increíbles de Colombia.
            </p>
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                <a href="tel:+5712345678" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-phone" style="width: 16px; text-align: center; color: #059669;"></i> +57 1 234 5678
                </a>
                <a href="mailto:info@colombiatravel.com" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-envelope" style="width: 16px; text-align: center; color: #059669;"></i> info@colombiatravel.com
                </a>
                <a href="https://colombiatravel.com" target="_blank" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-globe" style="width: 16px; text-align: center; color: #059669;"></i> Web
                </a>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <a href="#" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #059669; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.color='#047857'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#059669'; this.style.transform='translateX(0)'">
                    Ver detalles <i class="fas fa-arrow-right"></i>
                </a>
                <button style="background: white; border: 2px solid #e2e8f0; color: #64748b; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#ef4444'; this.style.color='#ef4444'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Agencia 2 -->
    <div style="border-radius: 20px; border: none; box-shadow: 0 8px 32px rgba(0,0,0,0.12); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; background: white; position: relative;" onmouseover="this.style.transform='translateY(-12px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.18)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'">
        <div style="position: relative; height: 200px; overflow: hidden; background: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);">
            <div style="position: absolute; bottom: -20px; left: 20px; width: 60px; height: 60px; border-radius: 50%; background: white; border: 4px solid white; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 2;">
                <i class="fas fa-leaf" style="color: #10b981;"></i>
            </div>
        </div>
        
        <div style="padding: 32px 24px 24px;">
            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 12px; line-height: 1.2;">Eco Tours Colombia</h3>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <div style="color: #f59e0b; font-size: 16px;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; color: #374151;">5.0</span>
            </div>
            <p style="font-family: 'Plus Jakarta Sans', sans-serif; color: #4b5563; font-size: 0.875rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px;">
                Líderes en ecoturismo y turismo sostenible. Descubre la naturaleza colombiana de forma responsable y educativa.
            </p>
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                <a href="tel:+5713456789" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-phone" style="width: 16px; text-align: center; color: #059669;"></i> +57 1 345 6789
                </a>
                <a href="mailto:contacto@ecotourscolombia.com" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-envelope" style="width: 16px; text-align: center; color: #059669;"></i> contacto@ecotourscolombia.com
                </a>
                <a href="https://ecotourscolombia.com" target="_blank" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-globe" style="width: 16px; text-align: center; color: #059669;"></i> Web
                </a>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <a href="#" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #059669; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.color='#047857'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#059669'; this.style.transform='translateX(0)'">
                    Ver detalles <i class="fas fa-arrow-right"></i>
                </a>
                <button style="background: white; border: 2px solid #e2e8f0; color: #64748b; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#ef4444'; this.style.color='#ef4444'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Agencia 3 -->
    <div style="border-radius: 20px; border: none; box-shadow: 0 8px 32px rgba(0,0,0,0.12); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; background: white; position: relative;" onmouseover="this.style.transform='translateY(-12px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.18)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'">
        <div style="position: relative; height: 200px; overflow: hidden; background: linear-gradient(135deg, #ea580c 0%, #c2410c 50%, #9a3412 100%);">
            <div style="position: absolute; bottom: -20px; left: 20px; width: 60px; height: 60px; border-radius: 50%; background: white; border: 4px solid white; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 2;">
                <i class="fas fa-hiking" style="color: #f59e0b;"></i>
            </div>
        </div>
        
        <div style="padding: 32px 24px 24px;">
            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 12px; line-height: 1.2;">Adventure Plus</h3>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <div style="color: #f59e0b; font-size: 16px;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; color: #374151;">4.6</span>
            </div>
            <p style="font-family: 'Plus Jakarta Sans', sans-serif; color: #4b5563; font-size: 0.875rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px;">
                Especialistas en turismo de aventura. Escalada, rafting, parapente y mucho más en los mejores escenarios de Colombia.
            </p>
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                <a href="tel:+5714567890" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-phone" style="width: 16px; text-align: center; color: #059669;"></i> +57 1 456 7890
                </a>
                <a href="mailto:info@adventureplus.com" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-envelope" style="width: 16px; text-align: center; color: #059669;"></i> info@adventureplus.com
                </a>
                <a href="https://adventureplus.com" target="_blank" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-globe" style="width: 16px; text-align: center; color: #059669;"></i> Web
                </a>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <a href="#" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #059669; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.color='#047857'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#059669'; this.style.transform='translateX(0)'">
                    Ver detalles <i class="fas fa-arrow-right"></i>
                </a>
                <button style="background: white; border: 2px solid #e2e8f0; color: #64748b; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#ef4444'; this.style.color='#ef4444'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Agencia 4 -->
    <div style="border-radius: 20px; border: none; box-shadow: 0 8px 32px rgba(0,0,0,0.12); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); overflow: hidden; background: white; position: relative;" onmouseover="this.style.transform='translateY(-12px) scale(1.02)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.18)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'">
        <div style="position: relative; height: 200px; overflow: hidden; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);">
            <div style="position: absolute; bottom: -20px; left: 20px; width: 60px; height: 60px; border-radius: 50%; background: white; border: 4px solid white; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 2;">
                <i class="fas fa-theater-masks" style="color: #8b5cf6;"></i>
            </div>
        </div>
        
        <div style="padding: 32px 24px 24px;">
            <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 12px; line-height: 1.2;">Cultural Express</h3>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                <div style="color: #f59e0b; font-size: 16px;">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; color: #374151;">4.9</span>
            </div>
            <p style="font-family: 'Plus Jakarta Sans', sans-serif; color: #4b5563; font-size: 0.875rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px;">
                Expertos en turismo cultural y educativo. Descubre la rica historia y tradiciones de Colombia con guías expertos.
            </p>
            <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                <a href="tel:+5715678901" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-phone" style="width: 16px; text-align: center; color: #059669;"></i> +57 1 567 8901
                </a>
                <a href="mailto:info@culturalexpress.com" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-envelope" style="width: 16px; text-align: center; color: #059669;"></i> info@culturalexpress.com
                </a>
                <a href="https://culturalexpress.com" target="_blank" style="display: flex; align-items: center; gap: 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.875rem; color: #6b7280; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.color='#059669'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#6b7280'; this.style.transform='translateX(0)'">
                    <i class="fas fa-globe" style="width: 16px; text-align: center; color: #059669;"></i> Web
                </a>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <a href="#" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #059669; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.color='#047857'; this.style.transform='translateX(4px)'" onmouseout="this.style.color='#059669'; this.style.transform='translateX(0)'">
                    Ver detalles <i class="fas fa-arrow-right"></i>
                </a>
                <button style="background: white; border: 2px solid #e2e8f0; color: #64748b; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#ef4444'; this.style.color='#ef4444'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
