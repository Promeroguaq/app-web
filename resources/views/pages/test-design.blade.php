@extends('layouts.app')

@section('title', 'Test de Diseño')

@section('subtitle', 'Verificando animaciones y diseño')

@section('content')
<!-- Hero Section con animación -->
<div class="hero-section" style="animation: slideInDown 1s ease-out;">
    <h1 style="animation: fadeInUp 1s ease-out 0.3s both;">🎨 TEST DE DISEÑO</h1>
    <p style="animation: fadeInUp 1s ease-out 0.6s both;">Verificando que las animaciones y el diseño funcionen correctamente</p>
</div>

<!-- Sección de prueba de animaciones -->
<div class="section-header">
    <h2>Animaciones y Efectos</h2>
</div>

<div class="content-grid">
    <!-- Tarjeta con animación -->
    <div class="card-item" style="animation: fadeInLeft 1s ease-out 0.9s both;">
        <h3>🎯 Animación FadeIn</h3>
        <p>Esta tarjeta debería aparecer con una animación suave desde la izquierda.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <span style="color: white;">🎨</span>
        </div>
    </div>
    
    <!-- Tarjeta con hover -->
    <div class="card-item" style="animation: fadeInRight 1s ease-out 1.2s both;">
        <h3>✨ Efecto Hover</h3>
        <p>Pasa el mouse sobre esta tarjeta para ver el efecto de elevación.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <span style="color: white;">✨</span>
        </div>
    </div>
    
    <!-- Tarjeta con animación -->
    <div class="card-item" style="animation: fadeInUp 1s ease-out 1.5s both;">
        <h3>🚀 Animación Up</h3>
        <p>Esta tarjeta aparece con una animación desde abajo.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <span style="color: white;">🚀</span>
        </div>
    </div>
</div>

<!-- Sección de prueba de colores y estilos -->
<div style="margin-top: 50px; padding: 40px; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.07); animation: fadeIn 1s ease-out 1.8s both;">
    <div class="section-header">
        <h2>Prueba de Estilos CSS</h2>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px;">
        <div style="background: #3b82f6; color: white; padding: 20px; border-radius: 8px; text-align: center; animation: pulse 2s infinite;">
            <h4>Color Azul</h4>
            <p>Animación pulse</p>
        </div>
        
        <div style="background: #10b981; color: white; padding: 20px; border-radius: 8px; text-align: center; animation: bounce 2s infinite;">
            <h4>Color Verde</h4>
            <p>Animación bounce</p>
        </div>
        
        <div style="background: #f59e0b; color: white; padding: 20px; border-radius: 8px; text-align: center; animation: shake 2s infinite;">
            <h4>Color Naranja</h4>
            <p>Animación shake</p>
        </div>
        
        <div style="background: #8b5cf6; color: white; padding: 20px; border-radius: 8px; text-align: center; animation: rotate 3s infinite linear;">
            <h4>Color Púrpura</h4>
            <p>Animación rotate</p>
        </div>
    </div>
</div>

<!-- Sección de prueba de transiciones -->
<div style="margin-top: 40px; padding: 30px; background: #f8f9fa; border-radius: 12px; animation: fadeIn 1s ease-out 2.1s both;">
    <div class="section-header">
        <h2>Prueba de Transiciones</h2>
    </div>
    
    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px;">
        <button style="background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 25px; cursor: pointer; transition: all 0.3s ease;" 
                onmouseover="this.style.transform='scale(1.1)'" 
                onmouseout="this.style.transform='scale(1)'">
            Hover Me
        </button>
        
        <button style="background: #10b981; color: white; padding: 12px 24px; border: none; border-radius: 25px; cursor: pointer; transition: all 0.3s ease;" 
                onmouseover="this.style.background='#059669'" 
                onmouseout="this.style.background='#10b981'">
            Color Change
        </button>
        
        <button style="background: #f59e0b; color: white; padding: 12px 24px; border: none; border-radius: 25px; cursor: pointer; transition: all 0.3s ease;" 
                onmouseover="this.style.boxShadow='0 5px 15px rgba(245, 158, 11, 0.4)'" 
                onmouseout="this.style.boxShadow='none'">
            Shadow Effect
        </button>
    </div>
</div>

<!-- Información de diagnóstico -->
<div class="alert-box" style="animation: fadeIn 1s ease-out 2.4s both;">
    <h3>🔍 Información de Diagnóstico</h3>
    <p>Si ves este contenido con animaciones y estilos, el diseño está funcionando correctamente.</p>
    <p>Fecha y hora: {{ date('Y-m-d H:i:s') }}</p>
    <p>URL actual: {{ request()->fullUrl() }}</p>
    <p>Layout: layouts.app</p>
</div>

@push('scripts')
<script>
// Animaciones CSS adicionales
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeInLeft {
        from {
            transform: translateX(-30px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeInRight {
        from {
            transform: translateX(30px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Página de test de diseño cargada');
    console.log('🎨 Animaciones CSS activadas');
    console.log('🔧 Layout: layouts.app');
    console.log('⏰ Fecha:', '{{ date("Y-m-d H:i:s") }}');
});
</script>
@endpush
@endsection
