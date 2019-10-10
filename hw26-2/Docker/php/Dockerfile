FROM php:7.3-fpm

WORKDIR /code

RUN apt-get update && apt-get install -y git zip procps netcat \
    && docker-php-ext-install bcmath pdo_mysql sockets \
    && curl -s https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
    
ENV COMPOSER_ALLOW_SUPERUSER 1

COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]