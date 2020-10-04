FROM php:7-fpm

ARG UID

RUN addgroup --gid $UID --system app \
    && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

RUN pecl install redis && docker-php-ext-enable redis

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

COPY --from=composer:1 /usr/bin/composer /usr/bin/composer
