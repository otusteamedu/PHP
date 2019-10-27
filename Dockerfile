FROM php:7.3-fpm as php

RUN apt update && apt install -y \
    git \
    unzip \
    --no-install-recommends \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /src

COPY . ./

RUN composer install --dev

RUN chown -R www-data:www-data /src

ENV PATH "$PATH:/src/vendor/bin"

CMD ["php-fpm"]
