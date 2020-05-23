FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git curl wget grep nano \ 
    libmemcached-dev zlib1g-dev libfreetype6-dev libcurl4-openssl-dev libssl-dev libpq-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install -of xdebug \
    && pecl install -of redis \
    && pecl install -of memcached \
    && docker-php-ext-enable xdebug redis memcached \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install -of raphf && docker-php-ext-enable raphf \
    && pecl install -of propro && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && echo "extension=http.so" >> /usr/local/etc/php/conf.d/docker-php-ext-zhttp.ini

WORKDIR /var/www/html
CMD ["php-fpm"]
