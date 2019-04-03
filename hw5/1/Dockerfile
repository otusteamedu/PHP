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

# Build
COPY composer.json .
COPY composer.lock .
ADD src src
RUN composer install

# Run tests
ADD tests tests
RUN ./vendor/bin/phpunit ./tests/

# Make executable
COPY calculator.php .
RUN chmod +x calculator.php

ENTRYPOINT ["./calculator.php"]
