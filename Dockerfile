FROM php:8.1-fpm-alpine

# Instala extensiones necesarias
RUN apk add --no-cache icu-dev libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev zlib-dev oniguruma-dev gmp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl pdo pdo_mysql opcache gmp gd

# Configura PHP
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/opcache.ini

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD ["php-fpm", "-F"]
