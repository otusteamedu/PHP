FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
	libicu-dev \
	libzip-dev \
	libcurl4-openssl-dev \
	libssl-dev \
	unzip

RUN docker-php-ext-install \
            intl \
            zip \
            pcntl \
            sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ARG UID
ARG GID
ARG USER
ARG GROUP

RUN addgroup --system --gid ${GID} ${GROUP} \
 && adduser --system --no-create-home -uid ${UID} --gid ${GID} \
    --disabled-password --disabled-login ${GROUP}

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

COPY php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
