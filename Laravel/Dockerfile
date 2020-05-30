FROM php:7.3-fpm-alpine

WORKDIR /usr/build

RUN apk add --no-cache libzip-dev \
 && docker-php-ext-install zip \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && composer --no-cache global require laravel/installer

ENV PATH "$PATH:/root/.composer/vendor/bin"

RUN laravel new blog

RUN addgroup -g 3000 -S app \
 && adduser -u 3000 -S -D -G app app \
 && chown -Rf app:app \
    .

CMD ["cp", "-rp", ".", "/usr/app"]