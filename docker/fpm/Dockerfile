FROM atimofeev/php-fpm-debian

LABEL maintainer="Alexandr Timofeev <tim31al@gmail.com>"

ARG UID
ARG GID
ARG USER
ARG GROUP

RUN addgroup --system --gid ${GID} ${GROUP} \
 && adduser --system --no-create-home -uid ${UID} --gid ${GID} \
    --disabled-password --disabled-login ${GROUP}

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

COPY php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
