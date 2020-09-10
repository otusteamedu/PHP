FROM php:7.4-fpm-alpine


ARG DEPS="bash vim git wget"
RUN apk update && apk add --no-cache $DEPS

#ARG DEPS_PHP="xdebug http pdo_pgsql mcrypt redis zip memcached"
ARG DEPS_PHP="xdebug http pdo_mysql mcrypt zip intl gd"
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod u+x /usr/local/bin/install-php-extensions \
    && sync \
    && install-php-extensions $DEPS_PHP
    
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php 
RUN php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

RUN rm /usr/local/etc/php/conf.d/*-xdebug.ini
COPY ./conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY ./conf/custom.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/
RUN chown -R www-data:www-data /var/www
