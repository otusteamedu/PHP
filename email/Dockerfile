FROM php:7.3-fpm-alpine

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY /app /data/app
WORKDIR /data/app
CMD ["composer", "install"]