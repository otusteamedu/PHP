FROM php:7.2-fpm
RUN apt-get update && apt-get install -y apt-utils vim gnupg2 make bash git wget curl grep libz-dev libmemcached-dev
RUN apt-get install -y zlib1g-dev libicu-dev libbrotli1 libcurl4-openssl-dev libssl-dev sysstat
RUN pecl install xdebug-2.7.1 && docker-php-ext-enable xdebug
RUN pecl install memcached && docker-php-ext-enable memcached
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install raphf && docker-php-ext-enable raphf
RUN pecl install propro && docker-php-ext-enable propro
ADD ./pgdg.list /etc/apt/sources.list.d/pgdg.list
RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -
RUN pecl install pecl_http && docker-php-ext-enable http
ADD ./php.ini /usr/local/etc/php/php.ini
RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet
RUN apt-get install -y postgresql-11 postgresql-server-dev-11 && docker-php-ext-install pdo_pgsql
WORKDIR /var/www