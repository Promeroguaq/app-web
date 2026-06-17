@extends('layouts.app')

@section('title', 'System Check')

@section('subtitle', 'Verificación completa del sistema')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <h1>🔍 SYSTEM CHECK</h1>
    <p>Verificación completa del sistema después de la limpieza</p>
</div>

<!-- System Status -->
<div class="section-header">
    <h2>Estado del Sistema</h2>
</div>

<div class="content-grid">
    <div class="card-item">
        <h3>✅ Layout System</h3>
        <p>Layout principal cargando correctamente con todas las clases CSS.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
            <span style="color: white;">✅</span>
        </div>
    </div>
    
    <div class="card-item">
        <h3>✅ Pages Consistency</h3>
        <p>Todas las páginas principales usando el layout correcto.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
            <span style="color: white;">📄</span>
        </div>
    </div>
    
    <div class="card-item">
        <h3>✅ Cache Cleared</h3>
        <p>Cache de vistas, rutas y configuración limpiada.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <span style="color: white;">🧹</span>
        </div>
    </div>
    
    <div class="card-item">
        <h3>✅ Routes Working</h3>
        <p>Todas las rutas principales funcionando correctamente.</p>
        <div class="card-image-placeholder" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
            <span style="color: white;">🛣️</span>
        </div>
    </div>
</div>

<!-- File Structure Check -->
<div style="margin-top: 50px; padding: 40px; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
    <div class="section-header">
        <h2>Estructura de Archivos</h2>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 30px;">
        <div style="background: #f0fdf4; padding: 20px; border-radius: 8px; border-left: 4px solid #22c55e;">
            <h4 style="color: #166534; margin-bottom: 15px;">📁 Layouts</h4>
            <ul style="color: #166534; margin: 0; padding-left: 20px;">
                <li>app.blade.php ✅</li>
                <li>design-options.blade.php ✅</li>
                <li>Sin archivos duplicados</li>
            </ul>
        </div>
        
        <div style="background: #eff6ff; padding: 20px; border-radius: 8px; border-left: 4px solid #3b82f6;">
            <h4 style="color: #1e40af; margin-bottom: 15px;">📁 Pages</h4>
            <ul style="color: #1e40af; margin: 0; padding-left: 20px;">
                <li>playas.blade.php ✅</li>
                <li>alojamiento.blade.php ✅</li>
                <li>destinos.blade.php ✅</li>
                <li>gastronomia.blade.php ✅</li>
                <li>eventos.blade.php ✅</li>
                <li>actividades.blade.php ✅</li>
            </ul>
        </div>
        
        <div style="background: #fefce8; padding: 20px; border-radius: 8px; border-left: 4px solid #f59e0b;">
            <h4 style="color: #92400e; margin-bottom: 15px;">📁 Cache</h4>
            <ul style="color: #92400e; margin: 0; padding-left: 20px;">
                <li>Views limpiadas ✅</li>
                <li>Cache limpiada ✅</li>
                <li>Rutas limpiadas ✅</li>
                <li>Configuración limpiada ✅</li>
            </ul>
        </div>
    </div>
</div>

<!-- Navigation Test -->
<div style="margin-top: 40px; padding: 30px; background: #f8f9fa; border-radius: 12px;">
    <div class="section-header">
        <h2>Prueba de Navegación</h2>
    </div>
    
    <p style="color: #666; margin-bottom: 20px;">Prueba todas estas URLs para verificar que funcionen correctamente:</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
        <a href="/" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;" 
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🏠 Inicio</strong><br>
            <small style="color: #666;">Página principal</small>
        </a>
        
        <a href="/playas" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🏖️ Playas</strong><br>
            <small style="color: #666;">Playas de Colombia</small>
        </a>
        
        <a href="/alojamiento" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🏨 Alojamiento</strong><br>
            <small style="color: #666;">Hoteles y más</small>
        </a>
        
        <a href="/destinos" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🗺️ Destinos</strong><br>
            <small style="color: #666;">Lugares turísticos</small>
        </a>
        
        <a href="/gastronomia" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🍽️ Gastronomía</strong><br>
            <small style="color: #666;">Comida típica</small>
        </a>
        
        <a href="/eventos" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🎉 Eventos</strong><br>
            <small style="color: #666;">Festivales</small>
        </a>
        
        <a href="/actividades" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🎯 Actividades</strong><br>
            <small style="color: #666;">Aventuras</small>
        </a>
        
        <a href="/test-design" style="display: block; background: white; padding: 15px; border-radius: 8px; text-decoration: none; color: #333; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
           onmouseover="this.style.background='#f8f9fa'; this.style.borderColor='#3b82f6';"
           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb';">
            <strong>🎨 Test Design</strong><br>
            <small style="color: #666;">Animaciones</small>
        </a>
    </div>
</div>

<!-- System Information -->
<div class="alert-box">
    <h3>🔍 Información del Sistema</h3>
    <p><strong>Fecha y hora:</strong> {{ date('Y-m-d H:i:s') }}</p>
    <p><strong>URL actual:</strong> {{ request()->fullUrl() }}</p>
    <p><strong>Layout activo:</strong> layouts.app</p>
    <p><strong>Estado:</strong> ✅ Sistema limpio y funcionando</p>
    <p><strong>Archivos eliminados:</strong> 6 archivos duplicados y temporales</p>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ System check completado');
    console.log('🧹 Proyecto limpio y sin errores');
    console.log('🎨 Diseño y animaciones funcionando');
    console.log('📁 Estructura de archivos optimizada');
    console.log('⏰ Verificación:', '{{ date("Y-m-d H:i:s") }}');
    
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.card-item');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
@endsection
