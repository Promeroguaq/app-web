@extends('layouts.app')

@section('title', 'Test de Efectos')

@section('subtitle', 'Verificación de márgenes, formas y efectos visuales')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <h1>🎨 TEST DE EFECTOS VISUALES</h1>
    <p>Verificando márgenes, formas y animaciones</p>
</div>

<!-- Section Header -->
<div class="section-header">
    <h2>🎯 Efectos y Animaciones</h2>
</div>

<div class="content-grid">
    <!-- Tarjeta con efectos hover -->
    <div class="card-item">
        <h3>✨ Efecto Hover Elevación</h3>
        <p>Pasa el mouse sobre esta tarjeta para ver el efecto de elevación y la barra superior animada.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <span style="color: white;">🎨</span>
        </div>
    </div>
    
    <!-- Tarjeta con gradientes -->
    <div class="card-item">
        <h3>🌈 Gradientes Animados</h3>
        <p>Esta tarjeta tiene gradientes y efectos de transición suaves.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
            <span style="color: white;">🌈</span>
        </div>
    </div>
    
    <!-- Tarjeta con sombras -->
    <div class="card-item">
        <h3>🌟 Sombras Dinámicas</h3>
        <p>Sombras que cambian al hacer hover y efectos de profundidad.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <span style="color: white;">🌟</span>
        </div>
    </div>
    
    <!-- Tarjeta con bordes redondeados -->
    <div class="card-item">
        <h3>🔄 Bordes Redondeados</h3>
        <p>Bordes perfectamente redondeados con transiciones suaves.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
            <span style="color: white;">🔄</span>
        </div>
    </div>
    
    <!-- Tarjeta con efectos de texto -->
    <div class="card-item">
        <h3>📝 Efectos de Texto</h3>
        <p>El título cambia de color al hacer hover.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #fa709a, #fee140);">
            <span style="color: white;">📝</span>
        </div>
    </div>
    
    <!-- Tarjeta con animaciones -->
    <div class="card-item">
        <h3>🎬 Animaciones CSS</h3>
        <p>Animaciones suaves y efectos de entrada.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #30cfd0, #330867);">
            <span style="color: white;">🎬</span>
        </div>
    </div>
</div>

<!-- Sección de márgenes y espaciado -->
<div style="margin-top: 60px; padding: 50px; background: white; border-radius: 25px; box-shadow: var(--shadow-lg); border: 1px solid var(--border-color);">
    <div class="section-header">
        <h2>📐 Márgenes y Espaciado</h2>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px;">
        <div style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); padding: 30px; border-radius: 20px; text-align: center; box-shadow: var(--shadow-md);">
            <h4 style="color: #1565c0; margin-bottom: 15px;">📏 Padding Generoso</h4>
            <p style="color: #1976d2;">30px de padding en todas direcciones</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #f3e5f5, #e1bee7); padding: 30px; border-radius: 20px; text-align: center; box-shadow: var(--shadow-md);">
            <h4 style="color: #7b1fa2; margin-bottom: 15px;">📐 Margen Externo</h4>
            <p style="color: #8e24aa;">60px de margen superior</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #e8f5e8, #c8e6c9); padding: 30px; border-radius: 20px; text-align: center; box-shadow: var(--shadow-md);">
            <h4 style="color: #388e3c; margin-bottom: 15px;">📦 Gap Consistente</h4>
            <p style="color: #43a047;">30px de espacio entre elementos</p>
        </div>
    </div>
</div>

<!-- Sección de formas y bordes -->
<div style="margin-top: 50px; padding: 40px; background: linear-gradient(135deg, #fff5f5, #ffe0e0); border-radius: 25px; box-shadow: var(--shadow-lg);">
    <div class="section-header">
        <h2>🔷 Formas y Bordes</h2>
    </div>
    
    <div style="display: flex; flex-wrap: wrap; gap: 25px; margin-top: 30px; justify-content: center;">
        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #ff6b6b, #ee5a24); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: var(--shadow-md);">
            15px
        </div>
        
        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #4ecdc4, #44a08d); border-radius: 25px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: var(--shadow-md);">
            25px
        </div>
        
        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #a8e6cf, #7fcdbb); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: var(--shadow-md);">
            50%
        </div>
        
        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #ffd3b6, #ffaaa5); border-radius: 20px 40px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; box-shadow: var(--shadow-md);">
            Mix
        </div>
    </div>
</div>

<!-- Alerta con efectos -->
<div class="alert-box">
    <h3>✅ Verificación Completa</h3>
    <p>Si ves todos estos efectos, márgenes y formas, el diseño está funcionando correctamente.</p>
    <p>Fecha: {{ date('Y-m-d H:i:s') }}</p>
    <p>Layout: layouts.app con efectos completos</p>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Test de efectos cargado');
    console.log('🎨 Verificando márgenes, formas y animaciones');
    console.log('📐 Layout con diseño completo aplicado');
    console.log('⏰ Fecha:', '{{ date("Y-m-d H:i:s") }}');
    
    // Animación de entrada para elementos
    const elements = document.querySelectorAll('.card-item');
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        setTimeout(() => {
            element.style.transition = 'all 0.6s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 150);
    });
    
    // Efecto parallax suave en el hero
    const hero = document.querySelector('.hero-section');
    if (hero) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        });
    }
});
</script>
@endpush
@endsection
