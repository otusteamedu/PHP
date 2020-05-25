FROM php:7.3-cli-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install sockets

WORKDIR /usr/app

COPY composer.* ./

RUN composer --no-cache --optimize-autoloader -- install

COPY config.ini.example config.ini

COPY src/ src/

COPY test.php start.sh ./

RUN chmod +x start.sh

CMD ["./start.sh"]