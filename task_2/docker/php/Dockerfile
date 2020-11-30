FROM php:7.4-fpm
ARG USER_UID

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libyaml-dev \
    && pecl install yaml \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable yaml \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && addgroup --gid $USER_UID --system app \
    && adduser --uid $USER_UID --system --disabled-password --disabled-login --gid $USER_UID app \
    && mkdir /sock \
    && chown -R app:app /sock

# COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html/public

USER app

CMD ["php-fpm", "--nodaemonize"]