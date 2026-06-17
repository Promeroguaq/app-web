# Organización del Proyecto Turismo App

## Estructura de Carpetas

### 📁 Archivos Principales (Raíz)
- `app/` - Lógica principal de la aplicación (Controllers, Models, Providers)
- `bootstrap/` - Archivos de inicialización
- `config/` - Configuración de la aplicación
- `database/` - Migraciones, seeders y factories
- `public/` - Archivos públicos accesibles desde web
- `resources/` - Vistas, assets y archivos de recursos
- `routes/` - Definición de rutas
- `storage/` - Archivos de almacenamiento (logs, cache, etc.)
- `tests/` - Tests unitarios y de integración
- `vendor/` - Dependencias de Composer
- `scripts/` - Scripts utilitarios

### 📁 Carpetas de Pruebas y Debug

#### `tests/database/`
Archivos para pruebas y verificación de base de datos:
- `check_*.php` - Scripts para verificar estructura y datos de tablas
- `check_connection.php` - Verificación de conexión a BD
- `check_db_*.php` - Scripts específicos de base de datos

#### `tests/debug/`
Archivos para debugging y solución de problemas:
- `debug_*.php` - Scripts de depuración
- `test_*.php` - Scripts de prueba específicos
- `final_test_*.php` - Tests finales de componentes

#### `scripts/`
Scripts utilitarios y herramientas:
- `ia.js` - Scripts de JavaScript utilitarios

## 🗂️ Archivos Movidos

### Desde la raíz a `tests/database/`:
- Todos los archivos `check_*.php` (30 archivos)

### Desde la raíz a `tests/debug/`:
- Todos los archivos `debug_*.php` (8 archivos)
- Todos los archivos `test_*.php` (8 archivos)
- `final_test_departamentos.php`
- `temp_check.php`

### Desde la raíz a `scripts/`:
- `ia.js`

## ✅ Beneficios de la Organización

1. **Limpieza**: La raíz del proyecto ahora contiene solo los archivos esenciales
2. **Claridad**: Los archivos de prueba y debug están agrupados por propósito
3. **Mantenimiento**: Más fácil encontrar y gestionar archivos específicos
4. **Colaboración**: Estructura más clara para otros desarrolladores

## 🚀 Uso

### Para ejecutar pruebas de base de datos:
```bash
php tests/database/check_connection.php
php tests/database/check_db_tables.php
```

### Para ejecutar scripts de debug:
```bash
php tests/debug/test_simple_filtering.php
php tests/debug/debug_filtering.php
```

### Para ejecutar scripts utilitarios:
```bash
node scripts/ia.js
```

## 📝 Notas

- Los archivos movidos mantienen su funcionalidad original
- Las rutas relativas pueden necesitar ajustes si referencian otros archivos
- Se recomienda agregar estas carpetas al `.gitignore` si no se desea versionar los archivos de prueba
- La estructura sigue las convenciones estándar de proyectos Laravel
