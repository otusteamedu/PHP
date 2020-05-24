FROM php:7.3-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get update && ACCEPT_EULA=Y apt-get install -y --no-install-recommends \
    libxml2-dev

RUN docker-php-ext-install \
    bcmath \
    pdo \
    ctype \
    json \
    mbstring \
    tokenizer \
    xml

WORKDIR /var/www/laravel