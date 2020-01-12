FROM php:7.4-fpm

RUN apt-get update && apt-get install -y git curl wget grep libmemcached-dev zlib1g-dev libpq-dev

RUN pecl config-set php_ini "${PHP_INI_DIR}/php.ini"

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && pecl install redis xdebug && docker-php-ext-enable redis xdebug \
    && pecl install memcached && docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup --gid 3000 --system app \
    && adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 app

CMD ["php-fpm"]
