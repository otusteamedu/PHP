FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    grep \
        libmemcached-dev \
    zlib1g-dev \
    libcurl4-openssl-dev \
    libbrotli-dev \
    libevent-dev \
    libicu-dev \
    libidn11-dev \
    libidn2-0-dev \
    libssl-dev \
        libpq-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        && pecl install redis memcached raphf propro \
        && docker-php-ext-enable redis memcached raphf propro \
    && pecl install pecl_http \
    && echo "extension=http.so" > /usr/local/etc/php/conf.d/pecl-http.ini \
       && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
       && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /tmp/pear
