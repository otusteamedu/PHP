# Домашнее задание №3

1. Необходимо установить любое расширение через pecl и через make (xdebug, redis)
    + прислать скриншот команды pecl list, где должно значиться расширение + вывод функции `php -i | grep "ваше расширение"`
    + прислать вывод команды make, т.е. `make > make_output.txt` + вывод функции `php -i | grep "ваше расширение"`
2. Необходимо создать свой пакет, и выложить в git и/или на packagist.org
    + прислать команду для клонирования с гита
    + прислать команду для установки через composer
3. Создать Docker-образ для работы
Необходимо создать образ, который будет включать:
    + образ php, берем с https://hub.docker.com/_/php/
    + необходимые утилиты (git, curl, wget, grep...)
    + установленный composer
    + установленные расширения redis, memcached, pecl_http, pdo_pgsql 


## Решение

###1. Установка расширений
Директория 1


###2. Создание своего пакета и размещение на гите
Директория 2, 2-установка

Создал свой пакет. Доступен по ссылке https://github.com/DmitriyShaydurov/simplePackage
+ Залил на https://packagist.org/packages/shaydurov/test
+ Настороил автоматическое обновление при каждом push на git
+ Команда для клонирования с гита: git clone https://github.com/DmitriyShaydurov/simplePackage.git 
+ Для установки в директории 2-установка надо выполнить команду: composer install 
+ в директории установка git выполняется установка с репозитория git 


###3. Создание Docker-образ для работы
Директория 3

Создал Docker-образ для работы. Образ собирается при помощи docker-compose.yml и состоит из 2 образов:
    1. nginx
    2. php:7.3-fpm
В свою очередь эти образы конфингурируюся Dockerfile-ми.
В образе php установлены:
    + Утилиты: git curl wget grep nano mc
    + composer
    + php-расширения: redis, memcached, raphf, propro, pecl_http (зависит от raphf и propro), pdo_pgsql 
Nginx обращается к php-fpm по 9000 порту.
Локальный конфигурационный файл nginx подключен как volume.
В виде volume-ов подключаются папки с корнем проекта и с логами веб сервера.

Команда для запуска образа:
    docker-compose up -d --build

Команды для остановки и удаления из памяти:
    docker-compose stop
    docker-compose rm -f

Команды запускаются из директории с docker-compose.yml файлом.