FROM php:7.4-fpm

ARG UID
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"  \
  && addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf