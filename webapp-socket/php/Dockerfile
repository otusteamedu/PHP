FROM php:7.2.13-fpm-alpine3.8

RUN addgroup -g 3000 -S astrviktor
RUN adduser -u 3000 -S -G astrviktor astrviktor

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

USER astrviktor

CMD ["php-fpm", "--nodaemonize"]
