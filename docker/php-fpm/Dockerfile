FROM php:7.4-fpm

#необходимые утилиты
RUN apt-get update && apt-get install -y \
curl \
libssl-dev \
git \
libzip-dev \
zip \
wget \
grep \
libz-dev \
libmemcached-dev \
libpq-dev \
libcurl4-openssl-dev \
nano \
&& docker-php-ext-install zip

RUN pecl install -o redis && docker-php-ext-enable redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/hw-otus/
EXPOSE 9000
CMD ["php-fpm"]
