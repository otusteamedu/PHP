FROM php:7.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends git wget libmemcached-dev zlib1g-dev libpq-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \\
    && pecl install redis && pecl install xdebug && pecl install memcached \\
    && docker-php-ext-enable memcached redis xdebug
RUN docker-php-ext-install pdo_pgsql