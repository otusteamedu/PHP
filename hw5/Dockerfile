FROM php:7.3-fpm-alpine

WORKDIR /usr/build

COPY app/ .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && composer -a -- dump-autoload

CMD ["cp", "-r", ".", "/usr/app"]