FROM php:7.4-fpm

COPY php.ini /usr/local/etc/php/
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN apt-get update \
    && apt-get install -y git curl wget grep mc procps \
    libmemcached-dev zlib1g-dev libfreetype6-dev libcurl4-openssl-dev libssl-dev libpq-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install -of xdebug && docker-php-ext-enable xdebug

CMD php-fpm --nodaemonize