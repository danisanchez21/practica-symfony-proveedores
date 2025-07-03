# Etapa 1: dependencias con Composer
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.* ./
RUN composer install --no-dev --prefer-dist --no-scripts --no-progress

# Etapa 2: PHP-FPM con extensiones necesarias para Symfony
FROM php:8.1-fpm-alpine

# Instala dependencias del sistema y extensiones PHP
RUN apk add --no-cache icu-dev libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev zlib-dev oniguruma-dev gmp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl pdo pdo_mysql opcache gmp gd

# Copia la app
WORKDIR /var/www/html
COPY --from=vendor /app /var/www/html
COPY . /var/www/html

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm", "-F"]
