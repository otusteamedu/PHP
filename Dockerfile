FROM php:alpine

RUN curl -sS https://getcomposer.org/installer | php -- \
    --quiet --install-dir=/usr/local/bin/ --filename=composer \
    && composer --version

# for debug
#RUN apk --no-cache add --virtual .deps autoconf gcc g++ make && \
#    pecl install xdebug && \
#    docker-php-ext-enable xdebug && \
#    apk del .deps

WORKDIR /app

COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
