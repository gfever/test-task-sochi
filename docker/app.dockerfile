FROM php:7.1-fpm-jessie

RUN apt-get update && apt-get install -y libmcrypt-dev  \
    zlib1g-dev \
    mysql-client \
    libmemcached-dev \
    && pecl install xdebug \
    && pecl install memcached \
    && docker-php-ext-enable xdebug memcached \
    && docker-php-ext-install opcache mbstring pdo_mysql mcrypt \