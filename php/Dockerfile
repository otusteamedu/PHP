FROM php:7.4-fpm

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git libpq-dev nano \
    && docker-php-ext-install sockets mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql
RUN usermod -u 1000 www-data

EXPOSE 9000

CMD ["php-fpm"]
