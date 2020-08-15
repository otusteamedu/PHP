# PHP

1. Необходимо установить любое расширение через pecl и через make (xdebug, redis)
- прислать скриншот команды pecl list, где должно значиться расширение + вывод функции `php -i | grep "ваше расширение"`
- прислать вывод команды make, т.е. `make > make_output.txt` + вывод функции `php -i | grep "ваше расширение"`

```
Файлы лежат в репозитории, вывод команды pecl list ниже
```
![alt tag](https://github.com/otusteamedu/PHP/blob/iglushkov/hm1-3/pecl_list.png)​

2. Необходимо создать свой пакет, и выложить в git и/или на packagist.org
- прислать команду для клонирования с гита
- прислать команду для установки через composer

```
Ссылка на packagist https://packagist.org/packages/iglushkov/composer_package_example

Для копирования пакета с packagist.org достаточно, прописать зависимость в composer.json проекта
и выполнить команду: composer install
```
```json
  "require": {
    "iglushkov/composer_package_example": "dev-master"
  }
```
```
Для копирования пакета с github нужно добавить ссылку на репозиторий в composer.json + зависимость в блок require
```
```json
{
    "require": {
      "iglushkov/composer_package_example": "dev-master"
    },
    "repositories":[
        {
            "type":"git",
            "url":"https://github.com/GlushkovIS/composer_package_example"
        }
    ]
}
```

3. Создать Docker-образ для работы
Необходимо создать образ, который будет включать:
- образ php, берем с https://hub.docker.com/_/php/
- необходимые утилиты (git, curl, wget, grep...)
- установленный composer
- установленные расширения redis, memcached, pecl_http, pdo_pgsql

```
Не получилось решить проблему с установкой pecl_http, как будто не находит http.so, хотя ищет по правильному пути
http.so - тоже скачивается и лежит в папке

Ссылка на образ docker тут:
https://hub.docker.com/repository/docker/glushkovis/otus-php
```
