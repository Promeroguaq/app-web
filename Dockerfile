```dockerfile
# syntax=docker/dockerfile:1

# =========================================================
# ETAPA 1: COMPILAR ASSETS DE VITE
# =========================================================
FROM node:22-bookworm-slim AS frontend

WORKDIR /app

# Copiar primero los archivos de dependencias para aprovechar caché
COPY package.json package-lock.json* ./

# Usar npm ci cuando exista package-lock.json
RUN if [ -f package-lock.json ]; then \
        npm ci; \
    else \
        npm install; \
    fi

# Copiar el proyecto y compilar Vite
COPY . .

RUN npm run build


# =========================================================
# ETAPA 2: APLICACIÓN LARAVEL
# =========================================================
FROM php:8.4-cli-bookworm

# Evitar preguntas interactivas durante la instalación
ENV DEBIAN_FRONTEND=noninteractive

# Instalar librerías necesarias para PHP y Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    ca-certificates \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer desde su imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio principal de la aplicación
WORKDIR /var/www/html

# Copiar el proyecto
COPY . .

# Instalar dependencias PHP de producción
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

# Copiar los assets compilados desde la etapa Node
COPY --from=frontend /app/public/build ./public/build

# Crear carpetas requeridas por Laravel
RUN mkdir -p \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Eliminar únicamente cachés de configuración o rutas que pudieran
# haberse copiado desde el entorno local.
# No eliminar packages.php ni services.php.
RUN rm -f \
    bootstrap/cache/config.php \
    bootstrap/cache/events.php \
    bootstrap/cache/routes-*.php

# Limpiar archivos temporales sin ejecutar php artisan cache:clear
RUN find storage/framework/cache/data -mindepth 1 -delete \
    && find storage/framework/sessions -mindepth 1 -delete \
    && find storage/framework/views -mindepth 1 -delete

# Crear enlace público de storage sin iniciar Laravel
RUN rm -rf public/storage \
    && ln -s /var/www/html/storage/app/public /var/www/html/public/storage

# Asignar permisos correctos
RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
    && chmod -R ug+rwX \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

# Ejecutar la aplicación como usuario sin privilegios
USER www-data

# Puerto utilizado por Render
EXPOSE 8080

# Render asigna PORT dinámicamente.
# 8080 queda como valor de respaldo.
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
```
