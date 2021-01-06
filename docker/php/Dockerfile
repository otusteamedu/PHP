FROM php:7.4-cli

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"  \
  && pecl install -o mongodb && docker-php-ext-enable mongodb
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf