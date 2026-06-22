/**
 * Rutas Colombia - Sistema de Preferencias
 * Persistencia de preferencias del usuario en localStorage
 */

const Preferences = {
    // Claves de localStorage
    KEYS: {
        PREFERRED_REGION: 'rutas-colombia.preferred-region',
        DEFAULT_EXPLORE_VIEW: 'rutas-colombia.default-explore-view',
        SHOW_CULTURE: 'rutas-colombia.show-culture',
        SHOW_NATURE: 'rutas-colombia.show-nature',
        SHOW_GASTRONOMY: 'rutas-colombia.show-gastronomy',
        THEME: 'rutas-colombia.theme',
        FONT_SIZE: 'rutas-colombia.font-size',
        REDUCE_MOTION: 'rutas-colombia.reduce-motion',
        REMEMBER_PREFERENCES: 'rutas-colombia.remember-preferences'
    },

    // Valores por defecto
    DEFAULTS: {
        PREFERRED_REGION: null,
        DEFAULT_EXPLORE_VIEW: 'destacados',
        SHOW_CULTURE: true,
        SHOW_NATURE: true,
        SHOW_GASTRONOMY: true,
        THEME: 'light',
        FONT_SIZE: 'normal',
        REDUCE_MOTION: false,
        REMEMBER_PREFERENCES: true
    },

    // Inicializar preferencias al cargar
    init() {
        // Aplicar tema antes de mostrar contenido para evitar parpadeo
        this.applyTheme();
        this.applyFontSize();
        this.applyReduceMotion();
        this.applyDashboardPreferences();
        
        // Sincronizar controles en la página de configuración
        this.syncControls();
        
        // Configurar botones de guardado
        this.setupSaveButtons();
        
        // Escuchar cambios en preferencias del sistema
        this.watchSystemPreferences();
    },

    // Obtener una preferencia
    get(key) {
        try {
            const value = localStorage.getItem(key);
            return value !== null ? JSON.parse(value) : this.DEFAULTS[key];
        } catch (e) {
            console.warn(`Error reading preference ${key}:`, e);
            return this.DEFAULTS[key];
        }
    },

    // Guardar una preferencia
    set(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (e) {
            console.warn(`Error saving preference ${key}:`, e);
        }
    },

    // Eliminar una preferencia
    remove(key) {
        try {
            localStorage.removeItem(key);
        } catch (e) {
            console.warn(`Error removing preference ${key}:`, e);
        }
    },

    // Eliminar todas las preferencias
    clearAll() {
        Object.values(this.KEYS).forEach(key => {
            this.remove(key);
        });
    },

    // Aplicar tema
    applyTheme() {
        const theme = this.get(this.KEYS.THEME);
        const html = document.documentElement;
        
        html.classList.remove('dark');
        
        if (theme === 'dark') {
            html.classList.add('dark');
        } else if (theme === 'auto') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (prefersDark) {
                html.classList.add('dark');
            }
        }
    },

    // Aplicar tamaño de fuente
    applyFontSize() {
        const fontSize = this.get(this.KEYS.FONT_SIZE);
        const body = document.body;
        
        body.classList.remove('font-size-comfortable');
        
        if (fontSize === 'comfortable') {
            body.classList.add('font-size-comfortable');
        }
    },

    // Aplicar reducción de movimiento
    applyReduceMotion() {
        const reduceMotion = this.get(this.KEYS.REDUCE_MOTION);
        const html = document.documentElement;
        
        if (reduceMotion) {
            html.classList.add('reduce-motion');
        } else {
            html.classList.remove('reduce-motion');
        }
    },

    // Aplicar preferencias del Dashboard
    applyDashboardPreferences() {
        const showCulture = this.get(this.KEYS.SHOW_CULTURE);
        const showNature = this.get(this.KEYS.SHOW_NATURE);
        const showGastronomy = this.get(this.KEYS.SHOW_GASTRONOMY);

        // Ocultar/mostrar secciones según preferencias
        const cultureSection = document.querySelector('[data-preference-section="culture"]');
        if (cultureSection) {
            cultureSection.style.display = showCulture ? 'block' : 'none';
        }

        const natureSection = document.querySelector('[data-preference-section="nature"]');
        if (natureSection) {
            natureSection.style.display = showNature ? 'block' : 'none';
        }

        const gastronomySection = document.querySelector('[data-preference-section="gastronomy"]');
        if (gastronomySection) {
            gastronomySection.style.display = showGastronomy ? 'block' : 'none';
        }
    },

    // Sincronizar controles visuales con localStorage
    syncControls() {
        // Región preferida
        const regionSelect = document.querySelector('[data-setting="preferred-region"]');
        if (regionSelect) {
            const preferredRegion = this.get(this.KEYS.PREFERRED_REGION);
            regionSelect.value = preferredRegion || '';
        }

        // Vista predeterminada
        const viewSelect = document.querySelector('[data-setting="default-explore-view"]');
        if (viewSelect) {
            const defaultView = this.get(this.KEYS.DEFAULT_EXPLORE_VIEW);
            viewSelect.value = defaultView || 'destacados';
        }

        // Switches de contenido
        const cultureSwitch = document.querySelector('[data-setting="show-culture"]');
        if (cultureSwitch) {
            cultureSwitch.checked = this.get(this.KEYS.SHOW_CULTURE);
        }

        const natureSwitch = document.querySelector('[data-setting="show-nature"]');
        if (natureSwitch) {
            natureSwitch.checked = this.get(this.KEYS.SHOW_NATURE);
        }

        const gastronomySwitch = document.querySelector('[data-setting="show-gastronomy"]');
        if (gastronomySwitch) {
            gastronomySwitch.checked = this.get(this.KEYS.SHOW_GASTRONOMY);
        }

        // Recordar preferencias
        const rememberSwitch = document.querySelector('[data-setting="remember-preferences"]');
        if (rememberSwitch) {
            rememberSwitch.checked = this.get(this.KEYS.REMEMBER_PREFERENCES);
        }

        // Tema
        const themeRadios = document.querySelectorAll('[data-setting="theme"]');
        const currentTheme = this.get(this.KEYS.THEME);
        themeRadios.forEach(radio => {
            radio.checked = radio.value === currentTheme;
        });

        // Tamaño de fuente
        const fontSizeSelect = document.querySelector('[data-setting="font-size"]');
        if (fontSizeSelect) {
            const currentFontSize = this.get(this.KEYS.FONT_SIZE);
            fontSizeSelect.value = currentFontSize || 'normal';
        }

        // Reducir animaciones
        const motionSwitch = document.querySelector('[data-setting="reduce-motion"]');
        if (motionSwitch) {
            motionSwitch.checked = this.get(this.KEYS.REDUCE_MOTION);
        }
    },

    // Configurar botones de guardado
    setupSaveButtons() {
        // Botón Guardar General
        const btnSaveGeneral = document.getElementById('btn-save-general');
        if (btnSaveGeneral) {
            btnSaveGeneral.addEventListener('click', () => {
                this.saveGeneral();
            });
        }

        // Botón Restablecer General
        const btnResetGeneral = document.getElementById('btn-reset-general');
        if (btnResetGeneral) {
            btnResetGeneral.addEventListener('click', () => {
                this.resetGeneral();
            });
        }

        // Botón Guardar Preferencias
        const btnSavePreferencias = document.getElementById('btn-save-preferencias');
        if (btnSavePreferencias) {
            btnSavePreferencias.addEventListener('click', () => {
                this.savePreferencias();
            });
        }

        // Botón Restablecer Preferencias
        const btnResetPreferencias = document.getElementById('btn-reset-preferencias');
        if (btnResetPreferencias) {
            btnResetPreferencias.addEventListener('click', () => {
                this.resetPreferencias();
            });
        }

        // Botón Guardar Privacidad
        const btnSavePrivacidad = document.getElementById('btn-save-privacidad');
        if (btnSavePrivacidad) {
            btnSavePrivacidad.addEventListener('click', () => {
                this.savePrivacidad();
            });
        }

        // Botón Restablecer Privacidad
        const btnResetPrivacidad = document.getElementById('btn-reset-privacidad');
        if (btnResetPrivacidad) {
            btnResetPrivacidad.addEventListener('click', () => {
                this.resetPrivacidad();
            });
        }

        // Botón Guardar Apariencia
        const btnSaveApariencia = document.getElementById('btn-save-apariencia');
        if (btnSaveApariencia) {
            btnSaveApariencia.addEventListener('click', () => {
                this.saveApariencia();
            });
        }

        // Botón Restablecer Apariencia
        const btnResetApariencia = document.getElementById('btn-reset-apariencia');
        if (btnResetApariencia) {
            btnResetApariencia.addEventListener('click', () => {
                this.resetApariencia();
            });
        }
    },

    // Guardar General
    saveGeneral() {
        const regionSelect = document.querySelector('[data-setting="preferred-region"]');
        if (regionSelect) {
            this.set(this.KEYS.PREFERRED_REGION, regionSelect.value || null);
        }
        this.showFeedback('Preferencias guardadas en este dispositivo');
    },

    // Restablecer General
    resetGeneral() {
        this.remove(this.KEYS.PREFERRED_REGION);
        const regionSelect = document.querySelector('[data-setting="preferred-region"]');
        if (regionSelect) {
            regionSelect.value = '';
        }
        this.showFeedback('Preferencias restablecidas');
    },

    // Guardar Preferencias
    savePreferencias() {
        const viewSelect = document.querySelector('[data-setting="default-explore-view"]');
        if (viewSelect) {
            this.set(this.KEYS.DEFAULT_EXPLORE_VIEW, viewSelect.value);
        }

        const cultureSwitch = document.querySelector('[data-setting="show-culture"]');
        if (cultureSwitch) {
            this.set(this.KEYS.SHOW_CULTURE, cultureSwitch.checked);
        }

        const natureSwitch = document.querySelector('[data-setting="show-nature"]');
        if (natureSwitch) {
            this.set(this.KEYS.SHOW_NATURE, natureSwitch.checked);
        }

        const gastronomySwitch = document.querySelector('[data-setting="show-gastronomy"]');
        if (gastronomySwitch) {
            this.set(this.KEYS.SHOW_GASTRONOMY, gastronomySwitch.checked);
        }

        this.applyDashboardPreferences();
        this.showFeedback('Preferencias guardadas en este dispositivo');
    },

    // Restablecer Preferencias
    resetPreferencias() {
        this.remove(this.KEYS.DEFAULT_EXPLORE_VIEW);
        this.remove(this.KEYS.SHOW_CULTURE);
        this.remove(this.KEYS.SHOW_NATURE);
        this.remove(this.KEYS.SHOW_GASTRONOMY);

        const viewSelect = document.querySelector('[data-setting="default-explore-view"]');
        if (viewSelect) {
            viewSelect.value = 'destacados';
        }

        const cultureSwitch = document.querySelector('[data-setting="show-culture"]');
        if (cultureSwitch) {
            cultureSwitch.checked = true;
        }

        const natureSwitch = document.querySelector('[data-setting="show-nature"]');
        if (natureSwitch) {
            natureSwitch.checked = true;
        }

        const gastronomySwitch = document.querySelector('[data-setting="show-gastronomy"]');
        if (gastronomySwitch) {
            gastronomySwitch.checked = true;
        }

        this.applyDashboardPreferences();
        this.showFeedback('Preferencias restablecidas');
    },

    // Guardar Privacidad
    savePrivacidad() {
        const rememberSwitch = document.querySelector('[data-setting="remember-preferences"]');
        if (rememberSwitch) {
            this.set(this.KEYS.REMEMBER_PREFERENCES, rememberSwitch.checked);
            
            if (!rememberSwitch.checked) {
                this.clearAll();
                this.syncControls();
                this.showFeedback('Preferencias eliminadas de este dispositivo');
            } else {
                this.showFeedback('Preferencias guardadas en este dispositivo');
            }
        }
    },

    // Restablecer Privacidad
    resetPrivacidad() {
        this.set(this.KEYS.REMEMBER_PREFERENCES, true);
        const rememberSwitch = document.querySelector('[data-setting="remember-preferences"]');
        if (rememberSwitch) {
            rememberSwitch.checked = true;
        }
        this.showFeedback('Preferencias restablecidas');
    },

    // Guardar Apariencia
    saveApariencia() {
        const themeRadios = document.querySelectorAll('[data-setting="theme"]');
        let selectedTheme = 'light';
        themeRadios.forEach(radio => {
            if (radio.checked) {
                selectedTheme = radio.value;
            }
        });
        this.set(this.KEYS.THEME, selectedTheme);
        this.applyTheme();

        const fontSizeSelect = document.querySelector('[data-setting="font-size"]');
        if (fontSizeSelect) {
            this.set(this.KEYS.FONT_SIZE, fontSizeSelect.value);
            this.applyFontSize();
        }

        const motionSwitch = document.querySelector('[data-setting="reduce-motion"]');
        if (motionSwitch) {
            this.set(this.KEYS.REDUCE_MOTION, motionSwitch.checked);
            this.applyReduceMotion();
        }

        this.showFeedback('Preferencias guardadas en este dispositivo');
    },

    // Restablecer Apariencia
    resetApariencia() {
        this.remove(this.KEYS.THEME);
        this.remove(this.KEYS.FONT_SIZE);
        this.remove(this.KEYS.REDUCE_MOTION);

        const themeRadios = document.querySelectorAll('[data-setting="theme"]');
        themeRadios.forEach(radio => {
            radio.checked = radio.value === 'light';
        });

        const fontSizeSelect = document.querySelector('[data-setting="font-size"]');
        if (fontSizeSelect) {
            fontSizeSelect.value = 'normal';
        }

        const motionSwitch = document.querySelector('[data-setting="reduce-motion"]');
        if (motionSwitch) {
            motionSwitch.checked = false;
        }

        this.applyTheme();
        this.applyFontSize();
        this.applyReduceMotion();
        this.showFeedback('Preferencias restablecidas');
    },

    // Escuchar cambios en preferencias del sistema
    watchSystemPreferences() {
        const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        darkModeQuery.addEventListener('change', () => {
            if (this.get(this.KEYS.THEME) === 'auto') {
                this.applyTheme();
            }
        });
    },

    // Mostrar mensaje de feedback
    showFeedback(message) {
        let feedbackContainer = document.querySelector('[data-feedback-container]');
        
        if (!feedbackContainer) {
            feedbackContainer = document.createElement('div');
            feedbackContainer.setAttribute('data-feedback-container', '');
            feedbackContainer.className = 'fixed bottom-4 right-4 z-50';
            document.body.appendChild(feedbackContainer);
        }

        const feedback = document.createElement('div');
        feedback.className = 'bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3 flex items-center gap-3 shadow-lg mb-2 animate-fade-in';
        feedback.innerHTML = `
            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
            <span class="text-emerald-800 text-sm font-medium">${message}</span>
        `;

        feedbackContainer.appendChild(feedback);

        setTimeout(() => {
            feedback.classList.add('animate-fade-out');
            setTimeout(() => feedback.remove(), 300);
        }, 3000);
    }
};

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => Preferences.init());
} else {
    Preferences.init();
}

// Hacer disponible globalmente
window.Preferences = Preferences;
