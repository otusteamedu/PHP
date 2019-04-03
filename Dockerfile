FROM php:alpine

RUN docker-php-ext-install sockets pcntl

RUN curl -sS https://getcomposer.org/installer | php -- \
    --quiet --install-dir=/usr/local/bin/ --filename=composer \
    && composer --version

WORKDIR /app

COPY composer.json .
COPY composer.lock .

RUN composer install

ADD src ./src/
ADD game.php .
RUN chmod +x game.php

CMD ./game.php

# for debug
#RUN apk --no-cache add --virtual .deps autoconf gcc g++ make && \
#    pecl install xdebug && \
#    docker-php-ext-enable xdebug && \
#    apk del .deps
