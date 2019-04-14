FROM php:7.1

MAINTAINER VORONIN NIKITA cubaman@mail.ru

# Install tools required for project
RUN apt-get update
RUN apt-get install -y --no-install-recommends git curl libcurl3 libcurl4-gnutls-dev zlib1g-dev libidn11-dev libmagic-dev libpq-dev wget grep \
    libgnutls28-dev libmemcached-dev libmemcached11 libmcrypt-dev gcc g++ make  

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer --version

# Install and enable packages
RUN pecl install -of redis && docker-php-ext-enable redis \
    && pecl install -of memcached && docker-php-ext-enable memcached \
    && pecl install -of raphf && docker-php-ext-enable raphf \
    && pecl install -of propro && docker-php-ext-enable propro \
    && pecl install -of pecl_http && echo "extension=http.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && docker-php-ext-install mysqli pdo_mysql pdo_pgsql \

