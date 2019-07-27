FROM php:7.1-fpm
RUN apt-get update
RUN apt-get install -y libpq-dev nano wget git
RUN docker-php-ext-install pdo pdo_pgsql bcmath sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app