FROM php:7-cli-alpine

RUN apk update && apk add --no-cache gcc \
    make \
    autoconf \
    g++ \
    openssl-dev \
    curl \
    unzip \
    libzip-dev \
    supervisor

RUN pecl install mongodb

RUN docker-php-ext-install bcmath && docker-php-ext-enable mongodb

CMD ["/usr/bin/supervisord", "-n"]