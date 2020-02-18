FROM php:7.4-fpm-alpine
WORKDIR /app

RUN addgroup -S -g 3000 app && adduser --uid 3000 -G app -SDH app

ARG DEPS="git mc nano vim"
RUN apk add --no-cache  $DEPS

ARG DEPS_PHP="http pdo_pgsql xdebug redis memcached"
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN docker-php-ext-enable opcache \
&& chmod u+x /usr/local/bin/install-php-extensions && sync && install-php-extensions $DEPS_PHP

RUN rm -rf /usr/local/etc/php && rm -rf /usr/local/etc/php-fpm.d
COPY ./conf/ /usr/local/etc/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./.profile /root/
