FROM php:7.2-fpm
RUN apt-get update
RUN apt-get install -y libpq-dev nano wget git zip unzip
RUN docker-php-ext-install pdo pdo_pgsql bcmath sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app

