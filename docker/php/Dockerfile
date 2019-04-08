FROM php:alpine
RUN apk --no-cache add icu-dev
RUN docker-php-ext-install intl

RUN curl -sS https://getcomposer.org/installer | php -- --quiet --install-dir=/usr/local/bin/ --filename=composer

# for debug
#RUN apk add --no-cache --virtual .deps gcc g++ autoconf make \
#    && pecl install xdebug-2.7.0 \
#    && docker-php-ext-enable xdebug \
#    && apk del .deps

USER 1000