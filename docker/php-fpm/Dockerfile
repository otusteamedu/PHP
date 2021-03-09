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

RUN pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ADD ./php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/hw-otus/
EXPOSE 9000
CMD ["php-fpm"]