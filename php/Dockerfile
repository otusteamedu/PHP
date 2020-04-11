FROM php:7.4-fpm
RUN apt-get update
RUN apt-get install -y libpq-dev libpq-dev
RUN docker-php-ext-install sockets pdo_pgsql
ARG UID
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app