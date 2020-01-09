FROM php:7.4-fpm
RUN apt-get update
RUN docker-php-ext-install \
        sockets

ARG UID
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app