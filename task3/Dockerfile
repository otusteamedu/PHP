FROM php:7.4-alpine
COPY ./web /var/www/html/web
WORKDIR /var/www/html/web

RUN apk add autoconf \
        gcc \
        libc-dev \
        make \
        pkgconfig \
        zlib-dev \
        libmemcached-dev \
        libcurl \
        curl-dev \
        libpq \
        postgresql-dev \
    && curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin \
    && echo "alias composer='composer'" >> /root/.bashrc \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install -of memcached \
    && docker-php-ext-enable memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && docker-php-ext-enable http \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql
