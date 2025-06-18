# Etapa de builder: compila dependencias y optimiza código
FROM php:8.1-fpm AS builder

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    libicu-dev libonig-dev libxml2-dev unzip git zip \
 && docker-php-ext-install pdo_mysql mbstring xml intl \
 && pecl install apcu \
 && docker-php-ext-enable apcu

WORKDIR /var/www/html

# Instala Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copia composer.json y lock, e instala dependencias sin ejecutar scripts
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copia el código de la aplicación (incluye bin/console)
COPY . .

# Etapa final: imagen ligera
FROM php:8.1-fpm

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    libicu-dev libonig-dev libxml2-dev \
 && docker-php-ext-install pdo_mysql mbstring xml intl \
 && pecl install apcu \
 && docker-php-ext-enable apcu \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copia desde el builder solamente lo necesario
COPY --from=builder /var/www/html /var/www/html

# Limpia la caché ahora que bin/console existe
RUN php bin/console cache:clear --no-warmup

# Copia y prepara entrypoint
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
