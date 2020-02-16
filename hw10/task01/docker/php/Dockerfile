FROM php:7-fpm-alpine
MAINTAINER WebFarrock <webfarrock@mail.ru>
WORKDIR /var/www/app.local

COPY ./docker/php/php.ini /usr/local/etc/php/
COPY ./docker/php/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
#COPY ./app/composer.json /var/www/app.local/composer.json

RUN apk add php7-dev \
        bash \
        gcc \
        g++ \
        make \
        curl \
        git \
        wget \
        grep \
        libmemcached-dev \
        zlib-dev \
        libzip-dev \
        curl-dev \
        libpq \
        postgresql-dev \
        icu-dev \
    && curl -sS https://getcomposer.org/installer | php -- \
            --filename=composer \
            --install-dir=/usr/local/bin && \
            echo "alias composer='composer'" >> /root/.bashrc && \
            composer \
    && pecl install -of redis \
    && docker-php-ext-enable --ini-name 01-redis.ini redis \
    && pecl install memcached \
    && docker-php-ext-enable --ini-name 02-memcached.ini memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable --ini-name 03-raphf.ini raphf \
    && pecl install -of propro \
    && docker-php-ext-enable --ini-name 04-propro.ini propro \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable --ini-name 05-pdo.ini pdo \
    && docker-php-ext-install sockets \
    && pecl install -of pecl_http \
    && docker-php-ext-enable --ini-name 06-http.ini http \
    && pecl install mongodb \
    && docker-php-ext-enable --ini-name 07-mongodb.ini mongodb \
    && docker-php-ext-install zip \
    && rm -rf /tmp/*

CMD composer install;  cp ./.env.example ./.env; php-fpm --nodaemonize;
