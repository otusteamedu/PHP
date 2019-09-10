FROM php:7.2-fpm
ENTRYPOINT ["sh", "./entrypoint.sh"]

RUN apt-get update && apt-get install -y \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev \
        libmcrypt-dev \
        libpq-dev \        
        zip \
        unzip \
        && pecl install mongodb \
        && docker-php-ext-enable mongodb

RUN docker-php-ext-install mbstring && \
    docker-php-ext-install exif && \
    docker-php-ext-install opcache && \
    docker-php-ext-install pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


