FROM php:7.3-fpm-alpine
RUN apk add git composer
RUN docker-php-ext-install sockets
WORKDIR /app
EXPOSE 9000