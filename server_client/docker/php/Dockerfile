FROM php:7.4-cli
ARG TYPE
RUN apt-get update \
    && apt-get install -y \
            autoconf \
            libevent-dev \
            zlib1g-dev \
            zlibc \
            libzip-dev \
            bzip2 \
            git \
            curl \
            wget \
            bash \
            libonig-dev \
            libpq-dev \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
# Install PHP extensions
    && docker-php-ext-install \
        mbstring \
        sockets \
        zip

WORKDIR /data/app/public
CMD [ "php", "app.php" , "${TYPE}"]