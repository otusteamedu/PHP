FROM php:7.4-fpm

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git libpq-dev\
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql && pecl install ds

RUN usermod -u 1000 www-data

EXPOSE 9000

CMD ["php-fpm"]