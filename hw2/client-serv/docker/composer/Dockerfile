FROM php:7.4-cli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /data/client-serv
CMD composer install && sleep 10