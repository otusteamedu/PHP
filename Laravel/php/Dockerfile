FROM php:7.3-fpm-alpine

RUN addgroup -g 3000 -S app \
 && adduser -u 3000 -S -D -G app app

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf \
 && mkdir /sock \
 && chown -Rf app:app \
    /sock

USER app

CMD ["php-fpm"]