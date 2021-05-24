FROM php:7.4-fpm

COPY zz-docker.conf /usr/local/etc/php-fpm.d/www.conf

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html

VOLUME /var/www/html

CMD ["php-fpm"]