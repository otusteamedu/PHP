FROM php:7.4-fpm

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
  && apt-get update \
  && apt-get install -y libcurl4-openssl-dev libssl-dev \
  && pecl install -o redis && docker-php-ext-enable redis