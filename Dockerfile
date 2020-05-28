FROM php:7.3.18-fpm-alpine

COPY . /app
WORKDIR /app
COPY .env.dist .env

RUN docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

CMD ["php-fpm"]