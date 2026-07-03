# Generar APK con PWABuilder - Rutas Colombia

## Requisitos previos

Antes de usar PWABuilder, asegúrate de que:

1. **La PWA está publicada en Render**
   - URL: `https://app-web-5csx.onrender.com`
   - El sitio debe abrir sin errores
   - HTTPS debe funcionar correctamente

2. **La PWA cumple con los requisitos básicos:**
   - Manifest válido
   - Service Worker registrado
   - Iconos de 192x192 y 512x512
   - Página offline funcional
   - Sin errores de consola
   - Sin mixed content

---

## Paso 1: Publicar cambios en Render

Si has realizado cambios recientes en la PWA:

1. Hacer commit y push del código:
   ```bash
   git add .
   git commit -m "Preparar PWA para PWABuilder"
   git push origin main
   ```

2. Esperar a que Render complete el despliegue
3. Verificar que `https://app-web-5csx.onrender.com` abre correctamente

---

## Paso 2: Validar la PWA localmente

Antes de usar PWABuilder, valida la PWA en tu navegador:

1. Abre `https://app-web-5csx.onrender.com` en Chrome
2. Abre DevTools (F12)
3. Ve a la pestaña **Application**
4. Verifica:
   - **Manifest**: Debe cargar sin errores
   - **Service Workers**: Debe estar registrado y activo
   - **Storage**: Debe mostrar caché
   - **Lighthouse**: Ejecuta Lighthouse > PWA audit

Si hay errores, corrígelos antes de continuar.

---

## Paso 3: Usar PWABuilder

1. **Entrar a PWABuilder**
   - URL: https://pwabuilder.com/

2. **Ingresar la URL de la PWA**
   - Pega: `https://app-web-5csx.onrender.com`
   - Haz clic en "Scan"

3. **Revisar los resultados del análisis**
   - PWABuilder analizará manifest, service worker, iconos
   - Corrige cualquier advertencia crítica
   - Los iconos PNG ya están preparados en `public/images/pwa/`

4. **Elegir paquete Android**
   - Haz clic en "Android"
   - Selecciona "Package for Android"

5. **Configurar el paquete**
   - **App Name**: Rutas Colombia
   - **Package Name**: com.promeroguaq.rutascolombia
   - **Version**: 1.0.0
   - **Theme Color**: #0f2d52
   - **Background Color**: #f8f5ef

6. **Seleccionar tipo de firma**
   - Para pruebas: "Debug" (no requiere keystore)
   - Para distribución: "Release" (requiere keystore)

7. **Generar el paquete**
   - Haz clic en "Generate"
   - Espera a que PWABuilder compile el APK
   - Descarga el ZIP generado

---

## Paso 4: Extraer el APK

1. **Descomprimir el ZIP**
   - El ZIP contiene el archivo `.apk`
   - Extrae el APK a una carpeta segura

2. **Renombrar el APK (opcional)**
   - Nombre sugerido: `RutasColombia-v1.0.0.apk`

---

## Paso 5: Probar la APK en Android

1. **Transferir la APK al teléfono**
   - Por USB, email, o enlace de descarga

2. **Instalar la APK**
   - Abre el archivo APK
   - Si es necesario, habilita "Instalar apps de fuentes desconocidas"
   - Confirma la instalación

3. **Validar la aplicación**
   - Abre la app
   - Verifica que carga la PWA correctamente
   - Prbar navegación, categorías, regiones
   - Prbar modo offline (desactiva WiFi/datos)
   - Verifica que el botón Atrás funciona correctamente

---

## Paso 6: Guardar claves de firma (Release)

Si generaste un APK release firmado:

1. **PWABuilder generará un keystore**
   - Descarga el archivo `.jks` o `.keystore`
   - Descarga las credenciales de firma

2. **Guardar en lugar seguro**
   - Ubicación recomendada: `C:\Users\Paola\android-keys\`
   - **NO subir a GitHub**
   - **NO compartir con terceros**
   - Guardar contraseña en gestor de contraseñas

3. **Documentar la información**
   - Package ID: com.promeroguaq.rutascolombia
   - Keystore path: (tu ubicación segura)
   - Keystore password: (guardar en gestor)
   - Key alias: (guardar en gestor)
   - Key password: (guardar en gestor)

---

## Paso 7: Publicar assetlinks.json (opcional)

Para quitar la barra del navegador en la APK instalada:

### Obtener la huella del certificado

1. **Si usaste PWABuilder con firma release:**
   - PWABuilder mostrará la huella SHA-256 del certificado
   - Copia esta huella

2. **Si usaste firma local con Android Studio:**
   ```bash
   keytool -list -v -keystore tu-keystore.jks -alias tu-alias
   ```
   - Copia el valor de "SHA256"

### Crear assetlinks.json

Crea el archivo `public/.well-known/assetlinks.json`:

```json
[
  {
    "relation": ["delegate_permission/common.handle_all_urls"],
    "target": {
      "namespace": "android_app",
      "package_name": "com.promeroguaq.rutascolombia",
      "sha256_cert_fingerprints": [
        "TU_HUELLA_SHA_256_AQUI"
      ]
    }
  }
]
```

**Importante:**
- Reemplaza `TU_HUELLA_SHA_256_AQUI` con la huella real
- No incluir espacios ni saltos de línea en la huella
- La huella debe estar en mayúsculas

### Publicar assetlinks.json

1. Agrega el archivo al proyecto
2. Hacer commit y push
3. Esperar despliegue en Render
4. Verificar que `https://app-web-5csx.onrender.com/.well-known/assetlinks.json` sea accesible

### Validar en Google Play Console

1. Ve a Google Play Console
2. Selecciona tu app
3. Ve a "Setup" > "App integrity"
4. Haz clic en "Verify assetlinks.json"
5. Google verificará que el archivo es correcto

---

## Actualizaciones de la aplicación

Para publicar una actualización:

1. **Mantener el mismo package ID**
   - `com.promeroguaq.rutascolombia` (no cambiar)

2. **Mantener el mismo keystore**
   - Usar el mismo keystore de release
   - Si pierdes el keystore, no podrás actualizar la app

3. **Aumentar versionCode**
   - En PWABuilder: incrementa el número de versión
   - Ejemplo: 1.0.0 → 1.0.1 → 1.1.0 → 2.0.0

4. **Cambiar versionName**
   - Debe reflejar la versión visual
   - Ejemplo: "1.0.1", "1.1.0", "2.0.0"

5. **Generar nueva APK**
   - Repetir el proceso en PWABuilder
   - Usar el mismo keystore

6. **Crear nuevo GitHub Release**
   - Tag: `v1.0.1`
   - Adjuntar nueva APK
   - Publicar

---

## Archivos que NO deben subirse a GitHub

```
*.jks
*.keystore
key.properties
build.json
*.apk
*.aab
assetlinks.json (si contiene huella real antes de verificar)
```

El `.gitignore` del proyecto ya excluye:
- `public/build/` (build de Vite)
- `node_modules/`
- `.env`

Asegúrate de no subir:
- Keystores
- Contraseñas
- APKs generados
- AABs generados

---

## Compartir la APK con personas de prueba

### Opción 1: GitHub Release

1. **Crear un Release en GitHub**
   - Ve al repositorio en GitHub
   - Haz clic en "Releases"
   - Haz clic en "Create a new release"

2. **Configurar el Release**
   - Tag: `v1.0.0`
   - Release title: `Rutas Colombia v1.0.0`
   - Description: Describe los cambios

3. **Adjuntar la APK**
   - Arrastra el archivo `RutasColombia-v1.0.0.apk`
   - Solo adjunta el APK, no el ZIP completo

4. **Publicar el Release**
   - Haz clic en "Publish release"

5. **Compartir el enlace**
   - Copia la URL del Release
   - Envíala a las personas de prueba

### Instrucciones para la persona que instala

```
1. Abre el enlace en tu teléfono Android.
2. Descarga el archivo APK.
3. Abre la app "Descargas" o "Archivos".
4. Toca el archivo APK descargado.
5. Si es necesario, permite la instalación desde fuentes desconocidas.
6. Toca "Instalar".
7. Espera a que termine la instalación.
8. Abre "Rutas Colombia" desde el menú de apps.
```

### Opción 2: Compartir directamente

1. Sube la APK a Google Drive, Dropbox, o similar
2. Genera un enlace de descarga
3. Comparte el enlace con instrucciones de instalación

---

## Solución de problemas

### La APK no se instala

- Verifica que tengas habilitada la instalación de apps de fuentes desconocidas
- Verifica que la APK no esté corrupta (descarga de nuevo)
- Verifica que la versión de Android sea compatible

### La app no carga la PWA

- Verifica que tengas conexión a internet
- Verifica que la URL de Render sea accesible
- Verifica que el manifest sea válido
- Revisa los logs de la app (si es posible)

### La barra del navegador sigue visible

- Verifica que `assetlinks.json` esté publicado
- Verifica que la huella SHA-256 sea correcta
- Verifica que Google Play Console haya validado el archivo
- Desinstala y reinstala la app

### El icono no aparece correctamente

- Verifica que los iconos PNG existan en `public/images/pwa/`
- Verifica que PWABuilder haya usado los iconos correctos
- Regenera la APK con iconos correctos

---

## Recursos

- [PWABuilder](https://pwabuilder.com/)
- [Android App Links](https://developer.android.com/training/app-links)
- [Google Play Console](https://play.google.com/console)
- [Lighthouse PWA Audit](https://web.dev/pwa/)

---

## Notas importantes

- **No subas contraseñas ni keystores a GitHub**
- **Guarda el keystore en un lugar seguro**
- **Si pierdes el keystore, no podrás actualizar la app**
- **Mantén el mismo package ID para todas las versiones**
- **Prueba la APK en dispositivos reales antes de distribuirla**
- **Verifica que la PWA funcione correctamente en Render antes de generar la APK**
