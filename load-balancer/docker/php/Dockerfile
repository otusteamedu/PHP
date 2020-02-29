FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
    wget

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && adduser --disabled-password --gecos "" user \
    && rm /usr/local/etc/php-fpm.d/zz-docker.conf \
    && mkdir /socket \
    && chown user:user /socket

COPY ./install-composer.sh ./install-composer.sh
RUN ./install-composer.sh && rm ./install-composer.sh