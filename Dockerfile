FROM php:7.3-fpm

LABEL maintainer="sunlazor at github.com"

WORKDIR "/opt/project"

# xDebug
RUN \
    pecl install -of xdebug-2.7.2 \
    && docker-php-ext-enable xdebug

ENV  XDEBUG_CONFIG="remote_host=host.docker.internal remote_enable=1"


# sockets
RUN docker-php-ext-install sockets

# Files

COPY server.php .
COPY client.php .

ENTRYPOINT ["bash"]