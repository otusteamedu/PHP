FROM php:7.4
COPY ./src /var/www/src
COPY ./public /var/www/public
COPY composer.json /var/www
COPY .env /var/www
WORKDIR /var/www
RUN apt update && apt install -y curl
RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
CMD composer install