FROM php:7.2-fpm
RUN apt-get update && apt-get install -y wget curl grep libz-dev libmemcached-dev
RUN pecl install xdebug-2.7.1 && docker-php-ext-enable xdebug
RUN pecl install memcached && docker-php-ext-enable memcached
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install raphf && docker-php-ext-enable raphf
RUN pecl install propro && docker-php-ext-enable propro
#RUN pecl install pecl_http && docker-php-ext-enable pecl_http
#RUN pecl install pdo_pgsql && docker-php-ext-enable pdo_pgsql
#RUN apt-get install php-http
ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /var/www