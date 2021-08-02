ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm
ARG PHP_ERROR_LOG_PATH
ARG X_DEBUG
ARG X_DEBUG_ERROR_LOG_PATH
ARG MEMPROF_LOG_PATH
ARG TIMEZONE

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
    curl \
    wget \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    # нужен для memprof
    libjudy-dev \
    # для memcached
    libmemcached11 \
    libmemcachedutil2 \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    # не работают с php =>8.0
    # && pecl install mcrypt-1.0.3 \
    # && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    # устанавливаем расширения PhpRedis, memprof, memcached
    && pecl install xdebug \
    redis \
    memcached \
    memprof \
    && docker-php-ext-enable xdebug \
    # устанавливаем файл настроек для redis
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable memprof \
    && docker-php-ext-install pdo \
    pgsql pdo_pgsql \
    # создаем файл для профилирования памяти. Без него отказывается работать memprof
    && touch /tmp/profile.heap

# копируем подготовленный php.ini
COPY ./conf/php/php.ini /usr/local/etc/php/php.ini
# копируем подготовленный xdebug.ini
COPY ./conf/X-Debug/x-debug.ini /usr/local/etc/php/xdebug.ini
# копируем файл для работы через сокет
COPY ./conf/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN if [ ${X_DEBUG} = true ]; then \
 cat /usr/local/etc/php/xdebug.ini >> /usr/local/etc/php/php.ini ; \
fi
RUN if [ ${X_DEBUG} = 1 ]; then \
 cat /usr/local/etc/php/xdebug.ini >> /usr/local/etc/php/php.ini ; \
fi
# Устанавливаем Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# оставил, чтобы не забыть как создавать папки
# RUN ["mkdir", "../tmp"]
# RUN ["mkdir", "/app"]


# устанавливаем рабочую директорию
# WORKDIR /var/www/html
WORKDIR /usr/local/etc

CMD ["php-fpm"]