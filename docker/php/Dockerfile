FROM php:7-fpm-alpine
WORKDIR /home/www/mysite.local

COPY ./php.ini /usr/local/etc/php/
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/

RUN apk add php7-dev \
        bash \
        gcc \
        g++ \
        make \
        nano \
        curl \
        git \
        wget \
        grep \
        libmemcached-dev \
        zlib-dev \
        curl-dev \
        libpq \
        postgresql-dev \
    && curl -sS https://getcomposer.org/installer | php -- \
            --filename=composer \
            --install-dir=/usr/local/bin && \
            echo "alias composer='composer'" >> /root/.bashrc && \
            composer \
    && pecl install -of xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && docker-php-ext-enable http \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable pdo \
    && docker-php-ext-install sockets \
    && addgroup -g 101 -S nginx \
    && adduser -u 101 -D -S -G nginx nginx \
    && rm -rf /tmp/*

EXPOSE 9000
CMD ["php-fpm"]