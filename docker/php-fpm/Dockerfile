FROM php:7.4-fpm

#необходимые утилиты
RUN apt-get update && apt-get install -y \
curl \
libssl-dev \
git \
wget \
grep \
libz-dev \
libmemcached-dev \
libpq-dev \
libcurl4-openssl-dev \
nano

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/hw-otus/
EXPOSE 9000
CMD ["php-fpm"]