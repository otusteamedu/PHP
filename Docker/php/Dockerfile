FROM php:7.1-fpm
ADD ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update && apt-get install -y libmcrypt-dev libpq-dev git procps
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && docker-php-ext-install bcmath sockets pdo_mysql \
    && docker-php-ext-configure bcmath

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9010" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini

# Allow composer to be run as super user
ENV COMPOSER_ALLOW_SUPERUSER 1
# Set the composer home directory
ENV COMPOSER_HOME /tmp
# Set the composer version
ENV COMPOSER_VERSION 1.7.2