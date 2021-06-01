FROM php:7.4-fpm

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git libpq-dev sendmail nano\
    && docker-php-ext-install sockets
RUN usermod -u 1000 www-data

EXPOSE 9000

CMD ["php-fpm"]

