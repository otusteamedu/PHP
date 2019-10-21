FROM php:7.2-fpm

RUN apt-get update && apt-get install -y vim git curl wget grep \
    libmemcached-dev zlib1g-dev \
        libfreetype6-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        libpq-dev
RUN        pecl install redis-4.0.1 \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
       && pecl install xdebug-2.6.0 \
       && pecl install memcached-3.0.4 \
       && docker-php-ext-enable redis xdebug memcached \
       && docker-php-ext-install pdo pdo_pgsql \
       && printf "\n" | pecl install raphf propro \
       && docker-php-ext-enable raphf propro \
       && printf "\n" | pecl install pecl_http \
&& pecl list
#VOLUME /data
#COPY ./data/index.html /usr/share/nginx/html/
#EXPOSE 80
