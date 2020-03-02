FROM php:7.4-cli-alpine
WORKDIR /app

ARG DEPS="git mc nano vim"
RUN apk add --no-cache $DEPS

ARG DEPS_PHP="xdebug ast opcache intl"
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod u+x /usr/local/bin/install-php-extensions && sync && install-php-extensions $DEPS_PHP \
    && rm /usr/local/etc/php/conf.d/*xdebug.ini \
    && mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir /tmp/.opcache
COPY ./docker/app/conf/php/custom.ini /usr/local/etc/php/conf.d/
COPY . .

RUN echo 'alias c="composer"' >> /root/.profile \
    && echo 'alias l="ls -lah"' >> /root/.profile

ENTRYPOINT ["php", "/app/index.php"]
CMD []

RUN composer install --no-cache --no-dev
