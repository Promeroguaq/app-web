FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias Node y compilar Vite
RUN npm install && npm run build

# Optimizar Laravel
RUN php artisan config:cache
RUN php artisan route:cache

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080