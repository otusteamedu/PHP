FROM php:7-fpm

RUN apt-get install -y curl
# Install composer
RUN curl -sS https://getcomposer.org/installer | \
            php -- --install-dir=/usr/bin/ --filename=composer

ENTRYPOINT ["./entrypoint.sh"]