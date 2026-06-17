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
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node y compilar Vite
RUN npm install && npm run build

# Limpiar cachés de Laravel
RUN php artisan route:clear
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear

# Generar enlace para storage
RUN php artisan storage:link || true

# Exponer puerto
EXPOSE 8080

# Iniciar Laravel
CMD php artisan serve --host=0.0.0.0 --port=8080