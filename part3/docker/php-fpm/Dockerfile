FROM php:fpm-alpine

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

CMD ["php-fpm","--nodaemonize"]