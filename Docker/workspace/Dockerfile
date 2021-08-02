ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm
ARG PHP_ERROR_LOG_PATH
ARG X_DEBUG
ARG X_DEBUG_ERROR_LOG_PATH
ARG MEMPROF_LOG_PATH

# Мета данные
LABEL version="1.0"
LABEL description="PHP-${PHP_VERSION} container"
LABEL maintainer = "Vladimir Valyakin"
ENV TZ=${TIMEZONE}
ENV ADMIN="Vladimir"
ENV MEMPROF_LOG_PATH=${MEMPROF_LOG_PATH}

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    # ставим необходимые для нормальной работы модули
    && apt update && apt install -y \
    mc \
    curl \
    wget \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    libjudy-dev \
    libmemcached11 \
    libmemcachedutil2 \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install xdebug \
    redis \
    memcached \
    memprof \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable memprof \
    && docker-php-ext-install pdo \
    pgsql pdo_pgsql \
    && touch /tmp/profile.heap
# копируем подготовленный php.ini
COPY ./conf/php/php.ini /usr/local/etc/php/php.ini
# копируем подготовленный xdebug.ini
COPY ./conf/X-Debug/x-debug.ini /usr/local/etc/php/xdebug.ini
RUN if [ ${X_DEBUG} = true ]; then \
 cat /usr/local/etc/php/xdebug.ini >> /usr/local/etc/php/php.ini ; \
fi
RUN if [ ${X_DEBUG} = 1 ]; then \
 cat /usr/local/etc/php/xdebug.ini >> /usr/local/etc/php/php.ini ; \
fi
# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# устанавливаем рабочую директорию
WORKDIR /var/www/html
# WORKDIR /usr/local/etc
VOLUME /var/www/html
