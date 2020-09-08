FROM php:7-cli

ARG UID
ARG SOCKET_PATH
ARG PORT

RUN addgroup --gid $UID --system app \
    && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

# Install PHP extensions
RUN docker-php-ext-install sockets
