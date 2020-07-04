

##### 1. Необходимо установить любое расширение через pecl и через make

###### Установка xdebug через pecl

Скачиваем образ, запускаем контейнер

    docker pull php:7.4-fpm-alpine
    docker run -d --rm --name install-by-pecl -it php:7.4-fpm-alpine
    
Заходим в контейнер
        
    docker exec -it install-by-pecl sh

Устанавливаем xdebug
    
    apk add php7-dev gcc g++ make
    pecl install -of xdebug
    docker-php-ext-enable xdebug
    
###### Установка xdebug через make    
    
Скачиваем образ, запускаем контейнер

    docker pull php:7.4-fpm-alpine
    docker run -d --rm --name install-by-make -it php:7.4-fpm-alpine
    
Заходим в контейнер
        
    docker exec -it install-by-make sh        
        
Устанавливаем xdebug
        
    apk add php7-dev gcc g++ make git           
    git clone https://github.com/xdebug/xdebug.git
    cd xdebug    
    phpize
    ./configure --enable-xdebug
    make
    make install
    docker-php-ext-enable xdebug
    
##### 2. Необходимо создать свой пакет

Клонирование с гита

    git clone git@github.com:darreg/helloworld.git

Утановка через composer
    
    composer require darreg/helloworld    
    
##### 3. Создать Docker-образ для работы

Запускаем контейнеры

    docker-compose up

PHPInfo доступно по ссылке

    http://localhost:8080/