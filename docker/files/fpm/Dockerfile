FROM php:8.0-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
        # не работают с php =>8.0
        #&& pecl install mcrypt-1.0.3 \
	#&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd 

# Устанавливка Composer не требуется в докере. Ее необходимо осуществить на хосте.
# Т.к. в контейнере проиходит только интерпретация кода. Все зависимости обновляются и устанавливаются
# в месте расопложения кода. Хотя бы потому что по умолчанию он будет установлен из под рута. Для решения
# проблемы требуется завести другого пользователя и из под него ставить composer.
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# при пробросе папок в форме записи соответсвия сначала идет папка из хоста, потом из контейнера
# в данном случае устанавливается соответсвие между папкой code, находящейся на уровень выше,
# чем Dockerfile  и /var/www/html/otus.loc в конейнере
# при использовании docker-compose все пробросы лучше прописать в docker-compose.yaml
# так же надо учесть, что папка из хоста перезапишет то, что находится в докере
#VOLUME ./code:/var/www/html/otus.loc
# пробрасываем файл конфигурации php.ini (по умолчанию его нужно скопировать в php.ini-production)
#VOLUME ./conf/php:/usr/local/etc/php

CMD ["php-fpm"]
