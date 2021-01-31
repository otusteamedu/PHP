FROM php:7.4-fpm

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
  && apt-get update \
  && apt-get install -y libcurl4-openssl-dev \
                        libssl-dev \
                        libpq-dev \
                        autoconf  \
                        libevent-dev \
                        zlib1g-dev \
                        zlibc \
                        libzip-dev \
                        bzip2 \
                        git \
                        curl \
                        wget \
                        bash \
                        libonig-dev \
                        libpq-dev \
  && docker-php-ext-install \
        mbstring \
        sockets \
        zip