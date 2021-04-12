FROM php:7.4-cli

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
  && apt-get update \
  && apt install -y zip unzip git  libcurl4-openssl-dev libssl-dev \
  && pecl install -o redis && docker-php-ext-enable redis \
  && pecl install -o mongodb && docker-php-ext-enable mongodb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/hw
CMD ["composer", "install"]