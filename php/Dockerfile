FROM php:7.4-fpm-alpine

ENV APP_DIR=/var/www/otus

COPY app $APP_DIR

WORKDIR $APP_DIR

RUN apk update && apk add git \
 && addgroup -g 3000 -S app \
 && adduser -u 3000 -S -D -G app app \
 && chown -R app:app $APP_DIR \
 && chmod -R g+w $APP_DIR \
 && mkdir -p /var/run/php \
 && chown -R app:app /var/run/php \
 && chmod -R g+w /var/run/php \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && composer install

USER app
