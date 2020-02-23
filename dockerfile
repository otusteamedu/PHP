FROM php:7.4
RUN apt-get update && \
        apt-get install -y \
            bash make g++ gcc grep zlib1g zlib1g-dev curl libcurl4-openssl-dev libcurl4 libevent-dev libidn11-dev \
            libssl-dev libmemcached-dev libpq-dev

RUN pecl install -of raphf && docker-php-ext-enable raphf && \
    pecl install -of propro && docker-php-ext-enable propro && \
    pecl install -of igbinary && docker-php-ext-enable igbinary && \
    pecl install -of zstd && docker-php-ext-enable zstd && \
    pecl install -of redis docker-php-ext-enable redis && \
    pecl install -of msgpack docker-php-ext-enable msgpack && \
    pecl install -of memcached docker-php-ext-enable memcached && \
    pecl install -of pecl_http docker-php-ext-enable http

RUN docker-php-ext-install pdo_pgsql

COPY ./src /var/www/html/

WORKDIR /var/www/html

EXPOSE 80:80