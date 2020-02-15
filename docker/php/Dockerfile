FROM php:7-fpm-alpine
WORKDIR /home/www/mysite.local

COPY ./php.ini /usr/local/etc/php/
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/

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
        curl-dev \
        libpq \
        postgresql-dev \
        mysql-dev \
        icu-dev \
    && curl -sS https://getcomposer.org/installer | php -- \
            --filename=composer \
            --install-dir=/usr/local/bin && \
            echo "alias composer='composer'" >> /root/.bashrc && \
            composer \
    && pecl install -of xdebug \
    && docker-php-ext-enable --ini-name 00-xdebug.ini xdebug \
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
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable --ini-name 05-pdo.ini pdo \
    && docker-php-ext-install sockets \
    && docker-php-ext-install pcntl \
    && pecl install -of pecl_http \
    && docker-php-ext-enable --ini-name 06-http.ini http \
    && pecl install -of mongodb \
    && docker-php-ext-enable --ini-name 07-mongodb.ini mongodb \
    && addgroup -g 101 -S nginx \
    && adduser -u 101 -D -S -G nginx nginx \
    && rm -rf /tmp/*

EXPOSE 9000
CMD ["php-fpm"]
