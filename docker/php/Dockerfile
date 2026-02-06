FROM php:8.2-fpm

# Instala extensões comuns do PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql zip

# Instala o Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# No Dockerfile do container PHP
RUN pecl install redis \
    && docker-php-ext-enable redis

# Configuração do Xdebug
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www
