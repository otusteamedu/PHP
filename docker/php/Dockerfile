FROM php:7.4-fpm

ARG UID
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
  && apt-get update \
  && apt-get install -y libcurl4-openssl-dev libssl-dev libpq-dev \
  && docker-php-ext-install pdo pdo_pgsql pgsql \
  && addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf