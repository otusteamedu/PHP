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

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#redis
RUN pecl install -o -f redis && docker-php-ext-enable redis

#memcached
RUN pecl install -o -f memcached && docker-php-ext-enable memcached

RUN pecl install -of raphf && docker-php-ext-enable raphf \
&& pecl install -of propro \
&& docker-php-ext-enable propro \
&& pecl install -of pecl_http

#pdo_pgsql
RUN docker-php-ext-install pdo_pgsql    

WORKDIR /var/www/
EXPOSE 80
CMD ["php-fpm"]