FROM php:7.3-cli-alpine

COPY . /usr/src/homework
WORKDIR /usr/src/homework

RUN apk add pcre-dev ${PHPIZE_DEPS} \
  && pecl install redis \
                  memcached \
#                  pecl_http \
#                  pdo_pgsql \
  && docker-php-ext-enable redis \
                           memcached
#                          pecl_http \
#                          pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
