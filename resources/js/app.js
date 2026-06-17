import './bootstrap';

// Funcionalidades JavaScript para la aplicación
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Turismo App loaded successfully');
    
    // Inicializar tooltips si se usa Bootstrap
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Manejo del menú móvil
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    const mobileOverlay = document.getElementById('mobileOverlay');
    
    if (mobileMenuToggle && sidebar && mobileOverlay) {
        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            mobileOverlay.classList.toggle('show');
        });
        
        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            mobileOverlay.classList.remove('show');
        });
    }
    
    // Animaciones al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observar elementos con clase .animate-on-scroll
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
});

// Utilidades globales
window.TurismoApp = {
    // Mostrar notificaciones
    showNotification: function(message, type = 'info') {
        console.log(`[${type.toUpperCase()}] ${message}`);
        // Aquí se puede integrar una librería de notificaciones
    },
    
    // Manejo de errores de API
    handleApiError: function(error) {
        console.error('API Error:', error);
        this.showNotification('Error en la solicitud', 'error');
    }
};
