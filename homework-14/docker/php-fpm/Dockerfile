FROM php:7-fpm

ARG UID

RUN addgroup --gid $UID --system app \
    && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

RUN apt-get update && apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_pgsql pdo_mysql

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

COPY --from=composer:1 /usr/bin/composer /usr/bin/composer
