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
Директория hw3.1

####1.1. Установка через pecl.
Написал скрипты, которые выполняют задание автоматически под Windows 10 с установелнным Docker Desktop.
    + hw3.1.install_pecl.bat если надо скачивает образ php:7.3-fpm-alpine, запускает с ним контейнер с заранее подготовленным скриптом hw3.1.install_pecl.sh
    + hw3.1.install_pecl.sh устанавливает dev пакет php, php-расширения xdebug и redis через pecl, выводит настройки php для проверки.
    + Происходит выход из контейннера.

Скриншоты:
    + Скриншот команды `pecl list` с установелнными расширениями xdebug и redis: http://joxi.ru/8AnGyJ9uzXJdnr
    + Скриншоты команды `php -i | grep -E '(redis|xdebug)'`:
        - http://joxi.ru/GrqzNb9h4V570m
        - http://joxi.ru/MAjGXy9ujEQ99r
        - http://joxi.ru/v294KxnhZ9yMBm

####1.2. Установка через make
Написал скрипты, которые выполняют задание автоматически под Windows 10 с установелнным Docker Desktop.
    + hw3.1.install_make.bat если надо скачивает образ php:7.3-fpm-alpine, запускает с ним контейнер с заранее подготовленным скриптом hw3.1.install_make.sh
    + hw3.1.install_make.sh устанавливает git, php-расширения xdebug и redis через make, выводит настройки php для проверки.
    + Происходит выход из контейннера, управление передаётся в hw3.1.install_make.bat, из контейнера копируются выдачи команд make на локальную машину.

Скриншоты команды `php -i | grep -E '(redis|xdebug)'`:
    + http://joxi.ru/EA495RZIojE46r
    + http://joxi.ru/n2Yn4QVub4zJDA
    + http://joxi.ru/82QDzkNSw6xXGm

Выдачи команд make:
    + hw3.1/make_output_xdebug.txt
    + hw3.1/make_output_redis.txt


###2. Создание своего пакета и размещение на гите
Директория hw3.2

Создал свой пакет. Доступен по ссылке https://github.com/leadorub/otus-backend-php-hw3.2.git
    + Команда для клонирования с гита: git clone https://github.com/leadorub/otus-backend-php-hw3.2.git
    + Для установки в директории hw3.2 надо выполнить команду: composer install


###3. Создание Docker-образ для работы
Директория hw3.3

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