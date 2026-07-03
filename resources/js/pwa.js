// Registrar Service Worker con scope raíz
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js', { scope: '/' })
        .then(registration => {
            console.log('✅ PWA: Service Worker registrado con scope /', registration);
            
            // Verificar actualizaciones periódicamente
            setInterval(() => {
                registration.update();
            }, 60 * 60 * 1000); // Cada hora
        })
        .catch(error => {
            console.error('❌ PWA: Error al registrar Service Worker', error);
        });
}

// Detectar si la app está en modo standalone (instalada)
window.TurismoApp = window.TurismoApp || {};
window.TurismoApp.isStandalone = window.matchMedia('(display-mode: standalone)').matches || 
                                    window.navigator.standalone === true;

// Disparar evento cuando TurismoApp está inicializado
window.dispatchEvent(new CustomEvent('pwa-ready'));

// Capturar evento beforeinstallprompt para instalación personalizada
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    
    // Disparar evento personalizado para que el UI pueda mostrar el botón
    window.dispatchEvent(new CustomEvent('pwa-install-available'));
});

window.addEventListener('appinstalled', () => {
    deferredPrompt = null;
    console.log('✅ PWA: App instalada exitosamente');
    window.dispatchEvent(new CustomEvent('pwa-installed'));
});

// Función para mostrar el prompt de instalación
window.TurismoApp.installPWA = async () => {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        deferredPrompt = null;
        
        if (outcome === 'accepted') {
            console.log('✅ PWA: Usuario aceptó instalación');
        } else {
            console.log('ℹ️ PWA: Usuario rechazó instalación');
        }
    }
};

// Detectar si la instalación está disponible
window.TurismoApp.canInstallPWA = () => {
    return !!deferredPrompt;
};

// Verificar conexión a internet
window.TurismoApp.isOnline = () => navigator.onLine;

window.addEventListener('online', () => {
    console.log('✅ PWA: Conexión restaurada');
    window.dispatchEvent(new CustomEvent('pwa-online'));
});

window.addEventListener('offline', () => {
    console.log('⚠️ PWA: Sin conexión');
    window.dispatchEvent(new CustomEvent('pwa-offline'));
});

export default updateSW;
