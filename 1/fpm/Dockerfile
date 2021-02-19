FROM php:7.4-fpm
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf
WORKDIR /code
VOLUME /code
CMD ["php-fpm"]
