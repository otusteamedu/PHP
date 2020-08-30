FROM php:7.4-fpm
ARG TIMEZONE

# Install extensions
RUN apt-get update && apt-get install -y \
        openssl \
        curl \
        libcurl4-openssl-dev \
        wget \
        git \
        libmemcached11 \
        libmemcachedutil2 \
        build-essential \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libssl-dev \
        --no-install-recommends apt-utils \
    && pecl install memcached redis xdebug \
    && docker-php-ext-enable memcached redis xdebug \
    && docker-php-ext-install pdo pdo_pgsql curl \
    && pecl install raphf propro \
    && docker-php-ext-enable raphf propro \
    && pecl install pecl_http \
    && echo -e "extension=raphf.so\nextension=propro.so\nextension=http.so" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-raphf.ini \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-propro.ini \
    && apt-get remove -y build-essential libmemcached-dev libz-dev \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /tmp/pear ~/.pearrc

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && mkdir /.composer/ && chmod 777 /.composer/

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

EXPOSE 9000
CMD ["php-fpm"]
