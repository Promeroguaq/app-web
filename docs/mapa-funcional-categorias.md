# Mapa Funcional de Categorías - Rutas Colombia

Este documento mapea cada categoría turística a su tabla, controlador, rutas y vistas correspondientes.

## Resumen de Correcciones Realizadas

1. **Deportes de Aventura**: Cambiado de `PuntoInteresController` a `DeporteAventuraController` (tabla no tiene ID_LOCALITIES)
2. **Playas**: Cambiado de `PuntoInteresController` a `PlayaController` (tiene ID_LOCALITIES)
3. **Reservas Naturales**: Cambiado de `PuntoInteresController` a `ReservaParqueController@reservasNaturales` (usa ID_REGIÓN)
4. **Fiestas y Ferias**: Cambiado de `PuntoInteresController` a `FeriaController` (no tiene relación con localities)

---

## Categorías con Rutas Corregidas

### 1. Deportes de Aventura
- **Nombre visible**: Deportes de Aventura
- **Tabla**: `tabla_deporte_aventura`
- **Clave primaria**: `ID_DEPORTES` (varchar(11))
- **Columna localities**: NO TIENE (usa `MUNICIPIOS` como texto libre)
- **Ruta index**: `puntos-interes.deportes-aventura`
- **Ruta show**: `puntos-interes.deportes-aventura.show`
- **Controlador index**: `DeporteAventuraController@index`
- **Controlador show**: `DeporteAventuraController@show`
- **Vista listado**: `pages/deportes-aventura.blade.php`
- **Vista detalle**: `pages/detalle-deporte-aventura.blade.php`
- **Registros**: 57
- **Relación con tabla_localities**: NO APLICA (campo MUNICIPIOS es texto libre)

### 2. Playas
- **Nombre visible**: Playas
- **Tabla**: `tabla_playas`
- **Clave primaria**: `ID_PLAYA` (varchar(8))
- **Columna localities**: `ID_LOCALITIES` (varchar(10))
- **Ruta index**: `puntos-interes.playas`
- **Ruta show**: `puntos-interes.playas.show`
- **Controlador index**: `PlayaController@index`
- **Controlador show**: `PlayaController@show`
- **Vista listado**: `pages/playas.blade.php`
- **Vista detalle**: `pages/detalle-playa.blade.php`
- **Registros**: 103
- **Relación con tabla_localities**: `tabla_playas.ID_LOCALITIES = tabla_localities.ID`

### 3. Reservas Naturales
- **Nombre visible**: Reservas Naturales
- **Tabla**: `tabla_reservas`
- **Clave primaria**: `ID_RESERVAS` (varchar(11))
- **Columna localities**: `ID_REGIÓN` (varchar(9))
- **Ruta index**: `puntos-interes.reservas-naturales`
- **Ruta show**: `puntos-interes.reservas-naturales.show`
- **Controlador index**: `ReservaParqueController@reservasNaturales`
- **Controlador show**: `ReservaParqueController@show`
- **Vista listado**: `pages/reservas-naturales.blade.php`
- **Vista detalle**: `pages/reservas-parques-detalle.blade.php`
- **Registros**: 169
- **Relación con tabla_localities**: `tabla_reservas.ID_REGIÓN = tabla_localities.REGION`

### 4. Fiestas y Ferias
- **Nombre visible**: Fiestas y Ferias
- **Tabla**: `tabla_ferias`
- **Clave primaria**: `ID_FIESTA` (varchar(9))
- **Columna localities**: NO TIENE (usa `CIUDAD_DEPARTAMENTO` como texto libre)
- **Ruta index**: `puntos-interes.fiestas-ferias`
- **Controlador index**: `FeriaController@index`
- **Controlador show**: `FeriaController@show`
- **Vista listado**: `pages/fiestas-ferias.blade.php`
- **Vista detalle**: `pages/fiesta-detalle.blade.php`
- **Registros**: 61
- **Relación con tabla_localities**: NO APLICA (campo CIUDAD_DEPARTAMENTO es texto libre)

---

## Otras Categorías (Ya con Controladores Dedicados)

### 5. Islas
- **Nombre visible**: Islas
- **Tabla**: `tabla_islas`
- **Clave primaria**: `ID_ISLA` (varchar(7))
- **Columna localities**: NO TIENE (tiene `DEPARTAMENTO` como texto)
- **Ruta index**: `puntos-interes.islas`
- **Ruta show**: `puntos-interes.islas.show`
- **Controlador index**: `IslaController@index`
- **Controlador show**: `IslaController@show`
- **Vista listado**: `pages/islas.blade.php`
- **Registros**: 13

### 6. Termales
- **Nombre visible**: Termales
- **Tabla**: `tabla_termales`
- **Clave primaria**: `ID_TERMALES` (varchar(11))
- **Columna localities**: `ID_LOCALITIES` (varchar(10))
- **Ruta index**: `puntos-interes.termales`
- **Ruta show**: `puntos-interes.termales.show`
- **Controlador index**: `TermalController@index`
- **Controlador show**: `TermalController@show`
- **Vista listado**: `pages/termales.blade.php`
- **Registros**: 29
- **Relación con tabla_localities**: `tabla_termales.ID_LOCALITIES = tabla_localities.ID`

### 7. Desiertos y Lagunas
- **Nombre visible**: Desiertos y Lagunas
- **Tabla**: `tabla_desierto_laguna`
- **Clave primaria**: `ID_DESIERTO` (varchar(11))
- **Columna localities**: `ID_LOCALITIES` (varchar(10))
- **Ruta index**: `puntos-interes.desiertos-lagunas`
- **Ruta show**: `puntos-interes.desiertos-lagunas.show`
- **Controlador index**: `DesiertoLagunaController@index`
- **Controlador show**: `DesiertoLagunaController@show`
- **Vista listado**: `pages/desiertos-lagunas.blade.php`
- **Registros**: 473
- **Relación con tabla_localities**: `tabla_desierto_laguna.ID_LOCALITIES = tabla_localities.ID`

### 8. Ciclismo
- **Nombre visible**: Ciclismo
- **Tabla**: `tabla_ciclismo`
- **Clave primaria**: `ID_CICLISMO` (varchar(11))
- **Columna localities**: `ID_LOCALITIES` (varchar(13))
- **Ruta index**: `puntos-interes.ciclismo`
- **Ruta show**: `puntos-interes.ciclismo.show`
- **Controlador index**: `CiclismoController@index`
- **Controlador show**: `CiclismoController@show`
- **Vista listado**: `pages/ciclismo.blade.php`
- **Registros**: 17
- **Relación con tabla_localities**: `tabla_ciclismo.ID_LOCALITIES = tabla_localities.ID`

### 9. Actividades en Parques
- **Nombre visible**: Actividades en Parques
- **Tabla**: `tabla_actividad_parque`
- **Clave primaria**: `ID_ACTIVIDAD` (varchar(12))
- **Columna localities**: `ID_LOCALITITES` (varchar(14)) - NOTA: TYPO EN NOMBRE DE COLUMNA
- **Ruta index**: `puntos-interes.actividades-parques`
- **Ruta show**: `puntos-interes.actividades-parques.show`
- **Controlador index**: `ActividadParqueController@index`
- **Controlador show**: `ActividadParqueController@show`
- **Vista listado**: `pages/actividades-parques.blade.php`
- **Registros**: 22
- **Relación con tabla_localities**: `tabla_actividad_parque.ID_LOCALITITES = tabla_localities.ID`

### 10. Museos
- **Nombre visible**: Museos
- **Tabla**: `tabla_museos`
- **Clave primaria**: `ID_MUSEO` (varchar(8))
- **Columna localities**: `ID_LOCALITIES` (varchar(10))
- **Ruta index**: `puntos-interes.museos`
- **Ruta show**: `puntos-interes.museos.show`
- **Controlador index**: `MuseoController@index`
- **Controlador show**: `MuseoController@show`
- **Vista listado**: `pages/museos.blade.php`
- **Registros**: 231
- **Relación con tabla_localities**: `tabla_museos.ID_LOCALITIES = tabla_localities.ID`

### 11. Turismo Religioso (Iglesias)
- **Nombre visible**: Turismo Religioso
- **Tabla**: `tabla_iglesias`
- **Clave primaria**: `ID_IGLESIA` (varchar(10))
- **Columna localities**: `ID_LOCALITIES` (varchar(10))
- **Ruta index**: `puntos-interes.iglesias`
- **Ruta show**: `puntos-interes.iglesias.show`
- **Controlador index**: `IglesiaController@index`
- **Controlador show**: `IglesiaController@show`
- **Vista listado**: `pages/iglesias.blade.php`
- **Registros**: 145
- **Relación con tabla_localities**: `tabla_iglesias.ID_LOCALITIES = tabla_localities.ID`

### 12. Parques Temáticos
- **Nombre visible**: Parques Temáticos
- **Tabla**: `tabla_parque_tematicos`
- **Clave primaria**: `ID_PARQUES` (varchar(10))
- **Columna localities**: `ID_LOCALITIES` (varchar(10))
- **Ruta index**: `puntos-interes.parques-tematicos`
- **Ruta show**: `puntos-interes.parques-tematicos.show`
- **Controlador index**: `ParqueTematicoController@index`
- **Controlador show**: `ParqueTematicoController@show`
- **Vista listado**: `pages/parques-tematicos.blade.php`
- **Registros**: 81
- **Relación con tabla_localities**: `tabla_parque_tematicos.ID_LOCALITIES = tabla_localities.ID`

---

## Tablas de Referencia

### tabla_localities
- **ID** (varchar(4)) - Clave primaria
- **REGION** (varchar(24))
- **MUNICIPIOS** (varchar(27))
- **DEPARTAMENTO** (varchar(56))
- **Registros**: 1124

### tabla_municipios
- **ID** (varchar(4)) - Clave primaria
- **NOMBRE_MUNICIPIOS** (varchar(40))
- **ID_LOCALITIES** (varchar(13)) - FK a tabla_localities.ID
- **DESCRIPCION** (varchar(2119))
- **Registros**: 1159

### tabla_departamentos
- **ID_DEPARTAMENTO** (varchar(15)) - Clave primaria
- **NOMBRE_DEPARTAMENTO** (varchar(40))
- **DESCRIPCION** (varchar(1441))
- **Registros**: 38

---

## Patrones de Relación con tabla_localities

### Tipo 1: Relación por ID (JOIN directo)
- `tabla_categoría.ID_LOCALITIES = tabla_localities.ID`
- Usado por: Playas, Termales, Desiertos/Lagunas, Ciclismo, Museos, Iglesias, Parques Temáticos

### Tipo 2: Relación por REGIÓN
- `tabla_categoría.ID_REGIÓN = tabla_localities.REGION`
- Usado por: Reservas Naturales

### Tipo 3: Sin relación (texto libre)
- Campo de texto con municipio/departamento
- Usado por: Deportes de Aventura (MUNICIPIOS), Fiestas y Ferias (CIUDAD_DEPARTAMENTO), Islas (DEPARTAMENTO)

---

## Archivos Modificados

1. `routes/web.php` - Corregidas rutas para Deportes de Aventura, Playas, Reservas Naturales, Fiestas y Ferias
2. `app/Http/Controllers/ReservaParqueController.php` - Agregado método `reservasNaturales()`
