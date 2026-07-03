# PWA y Mobile Roadmap - Rutas Colombia

## Fase 1: PWA Instalable desde Navegador ✅

**Estado:** Completado

**Objetivo:** Convertir la aplicación web Laravel en una Progressive Web App instalable desde navegadores compatibles.

**Implementación:**
- Instalación de `vite-plugin-pwa` compatible con Vite 7
- Configuración de manifest con datos de Rutas Colombia
- Creación de iconos SVG para PWA (192x192, 512x512, maskable)
- Meta tags para iOS (theme-color, apple-mobile-web-app-capable)
- Registro de Service Worker con estrategia de caché segura
- Botón de instalación en Dashboard (Android/Chrome)
- Instrucciones de instalación para iPhone/iPad (Safari)
- Página offline estática premium
- Estrategia de caché: NetworkFirst para navegación, CacheFirst para assets

**Archivos creados/modificados:**
- `vite.config.js` - Configuración PWA
- `resources/js/pwa.js` - Lógica de registro Service Worker
- `resources/js/app.js` - Import de pwa.js
- `resources/views/layouts/premium.blade.php` - Meta tags iOS
- `resources/views/pages/dashboard.blade.php` - Botón instalación
- `public/offline.html` - Página offline
- `public/images/pwa/` - Iconos PWA

**Validación:**
- Manifest carga correctamente
- Service Worker se registra
- Instalación disponible en Chrome Android
- Instrucciones visibles en Safari iOS
- Página offline funciona sin conexión

---

## Fase 2: Validar PWA Instalada en Android e iPhone

**Estado:** Pendiente

**Objetivo:** Probar la PWA instalada en dispositivos reales y emuladores.

**Tareas:**
- [ ] Instalar PWA en Chrome Android (dispositivo físico o emulador)
- [ ] Instalar PWA en Safari iPhone/iPad (dispositivo físico)
- [ ] Verificar modo standalone (sin barra de navegador)
- [ ] Probar navegación interna en modo standalone
- [ ] Verificar que enlaces externos abren navegador del sistema
- [ ] Probar comportamiento del botón Atrás
- [ ] Validar caché offline
- [ ] Verificar actualización de Service Worker
- [ ] Probar en diferentes tamaños de pantalla

**Dispositivos a probar:**
- Android: Chrome (última versión)
- iOS: Safari (iPhone, iPad)
- Escritorio: Chrome, Edge, Safari

---

## Fase 3: Crear Wrapper Nativo con Capacitor

**Estado:** Pendiente

**Objetivo:** Empaquetar la PWA como aplicación nativa Android e iOS usando Capacitor.

**Requisitos previos:**
- Node.js 20+
- JDK 17 (Android)
- Android Studio con Android SDK
- Xcode (iOS, solo en macOS)
- Capacitor CLI

**Pasos:**

### 3.1 Instalar Capacitor
```bash
npm install @capacitor/core @capacitor/cli @capacitor/android @capacitor/ios
npx cap init
```

### 3.2 Configurar Capacitor
- Crear `capacitor.config.ts` con:
  - App name: Rutas Colombia
  - App ID: com.promeroguaq.rutascolombia
  - Web dir: public/build
  - Server URL: https://app-web-5csx.onrender.com

### 3.3 Agregar plataformas
```bash
npx cap add android
npx cap add ios
```

### 3.4 Construir y sincronizar
```bash
npm run build
npx cap sync
```

### 3.5 Configurar Android
- Configurar `android/app/build.gradle`
- Configurar `android/app/src/main/AndroidManifest.xml`
- Ajustar permisos mínimos
- Configurar iconos y splash screen

### 3.6 Configurar iOS
- Configurar `ios/App/App/info.plist`
- Ajustar permisos
- Configurar iconos y splash screen

**Nota:** No empaquetar PHP, MySQL, `.env`, ni backend Laravel. La app nativa solo carga la PWA publicada en Render.

---

## Fase 4: Generar APK/AAB para Android

**Estado:** Pendiente

**Objetivo:** Compilar y firmar APK debug y release, y AAB para Google Play.

### 4.1 APK Debug (pruebas)
```bash
cd android
./gradlew assembleDebug
```

**Ubicación:** `android/app/build/outputs/apk/debug/app-debug.apk`

### 4.2 Generar Keystore (release)
```bash
keytool -genkeypair -v \
  -keystore rutas-colombia-release.keystore \
  -alias rutascolombia \
  -keyalg RSA \
  -keysize 2048 \
  -validity 10000
```

**Ubicación segura:** Fuera del repositorio (ej: `C:\Users\Paola\android-keys\`)

### 4.3 Configurar firma en Android
- Crear `android/keystore.properties` (no versionado)
- Configurar `android/app/build.gradle` con firma

### 4.4 APK Release (firmado)
```bash
cd android
./gradlew assembleRelease
```

**Ubicación:** `android/app/build/outputs/apk/release/app-release.apk`

### 4.5 AAB para Google Play
```bash
cd android
./gradlew bundleRelease
```

**Ubicación:** `android/app/build/outputs/bundle/release/app-release.aab`

---

## Fase 5: Proyecto iOS y Distribución Apple

**Estado:** Pendiente

**Objetivo:** Compilar proyecto iOS para distribución mediante herramientas Apple.

**Requisitos:**
- macOS con Xcode 15+
- Cuenta Apple Developer (paga)
- Certificados de desarrollo y distribución
- Provisioning Profiles

**Pasos:**

### 5.1 Abrir proyecto en Xcode
```bash
npx cap open ios
```

### 5.2 Configurar signing
- Agregar Apple ID en Xcode
- Configurar Team
- Configurar Bundle Identifier: com.promeroguaq.rutascolombia
- Configurar Signing & Capabilities

### 5.3 Compilar para dispositivo
- Seleccionar dispositivo físico
- Product > Run
- Probar funcionalidad

### 5.4 Archivo IPA (TestFlight/App Store)
- Product > Archive
- Distribuir via App Store Connect
- Subir a TestFlight para pruebas
- Submit para revisión App Store

**Nota:** iOS no usa APK. La distribución es vía TestFlight y App Store.

---

## Diferencias Importantes

### PWA vs APK vs App iOS

| Característica | PWA | APK Android | App iOS |
|---------------|-----|-------------|---------|
| Instalación | Navegador | APK/IPA | App Store |
| Distribución | Web directa | Google Play / sideload | App Store |
| Actualización | Automática (Service Worker) | Manual o Play Store | App Store |
| Offline | Service Worker | Service Worker + nativo | Service Worker + nativo |
| Acceso hardware | Limitado | Completo | Completo |
| Revisión | No necesaria | Google Play opcional | Apple obligatoria |

### Backend Laravel

**En todos los casos:**
- Laravel sigue funcionando en Render como backend
- La app (PWA, APK, iOS) carga la versión publicada
- No se empaqueta PHP, MySQL, ni `.env`
- Requiere conexión a internet para contenido dinámico

---

## Recursos

- [Capacitor Documentation](https://capacitorjs.com/docs)
- [Android App Signing](https://developer.android.com/studio/publish/app-signing)
- [iOS App Distribution](https://developer.apple.com/documentation/xcode/distributing-your-app-for-beta-testing-and-releases)
- [PWA Best Practices](https://web.dev/progressive-web-apps/)

---

## Notas de Seguridad

**Nunca incluir en repositorio:**
- Keystores (`.keystore`, `.jks`)
- Contraseñas de firma
- `keystore.properties`
- Certificados iOS
- Provisioning Profiles con datos sensibles

**Usar archivos de ejemplo:**
- `keystore.properties.example`
- Documentar variables de entorno necesarias
