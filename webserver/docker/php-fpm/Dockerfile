FROM php:7.4.0-fpm-alpine3.10

RUN docker-php-ext-install sockets && set -x && addgroup -g 101 -S nginx \
&& adduser -u 101 -D -S -G nginx nginx \
&& mkdir -p /var/www/mysite.local \
&& apk update \
&& apk add bash git autoconf gcc g++ make pkgconfig zlib-dev libmemcached-dev curl-dev libpq postgresql-dev \
libevent-dev icu-dev libidn-dev spl \
&& php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
&& php composer-setup.php --install-dir=/usr/bin/ --filename=composer \
&& '' | pecl install -o redis && docker-php-ext-enable --ini-name 00-redis.ini redis \
&& '' | pecl install -o memcached && docker-php-ext-enable --ini-name 01-memcached.ini memcached \
&& '' | pecl install -o raphf && docker-php-ext-enable --ini-name 02-raphf.ini raphf \
&& '' | pecl install -o propro && docker-php-ext-enable --ini-name 03-propro.ini propro \
&& '' | pecl install -o pecl_http && docker-php-ext-enable --ini-name 04-http.ini http \
&& docker-php-ext-install pdo_pgsql

WORKDIR /var/www/mysite.local
CMD composer install; /usr/local/sbin/php-fpm -F -R