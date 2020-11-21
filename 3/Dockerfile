FROM php:7.4-cli
#docker build -t hw1-3 .
#docker run -it --rm --name simple hw1-3

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN apt-get update \
    && apt-get install -y git wget zlib1g-dev libmemcached-dev libpq-dev libcurl4-openssl-dev openssl libssh-dev \
    && pecl install -o raphf-2.0.1 && docker-php-ext-enable raphf \
    && pecl install -o propro-2.1.0 && docker-php-ext-enable propro \
    && pecl install -o pecl_http-3.2.2 && docker-php-ext-enable http \
    && pecl install -o redis-5.3.2 && docker-php-ext-enable redis \
    && pecl install -o memcached-3.1.5 && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer3