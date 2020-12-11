# Домашняя работа

Цель: Познакомиться с различными типами организации окружения. Осознать их применимость и необходимость. Научиться настраивать рабочее окружение для своих проектов с использованием автоматизации. 

## 1. Docker

В каталоге Docker находится Dockerfile для развертывания статического сайта на базе Nginx.

``cd Docker && docker build -t pivahov_hw11 . && docker run -d -p 8080:80 pivanov_hw11``

## 2. Vagrant

В каталоге VM находится Vagrantfile для поднятия виртуальной машины valarel/homestead

``cd VM && vagrant up``

## 3. Сравнение целесообразности разворачивания инфраструктуры в облаке

Комания, в которой я работаю в настоящий момент, занимается интернет рекламмой и имеет собственный (железный) сервер на площадке хостера.
Такая организация инфраструктуры более выгодна, т.к. имеет фиксированную ежемесячную плату за гарантированные ресурсы.

## 4. Bash-скрипты

### 4.1 Суммирование чисел

Написать консольное приложение (bash-скрипт), который принимает два числа и выводит их сумму в стандартный вывод.
Если предоставлены неверные аргументы (для проверки на число можно использовать регулярное выражение) вывести ошибку в консоль.

``bash ./hw1/Scripts/sum.sh 5 7``

### 4.2 Вывод популярных городов

``bash ./hw1/Scripts/populate.sh ./hw1/Scripts/table.txt``
---
Полезные ссылки:

[Статья на Хабре "Bash-скрипты, часть 3"](https://habr.com/ru/company/ruvds/blog/326328/)

## 5.1 Установить расширение через pecl и через make (xdebug, redis)

В [Dockerfile.pecl](/hw1/lesson_3/part1/Dockerfile.pecl) инструкции для установки PHP расширения XDebug через PECL

![Вывод команды pecl list && php -i |grep xdebug](/hw1/lesson_3/part1/pecl_install_xdebug.png)

В [Dockerfile.make](/hw1/lesson_3/part1/Dockerfile.make) инструкции для установки PHP расширения Redis из исходного текста.
[Результат работы](/hw1/lesson_3/part1/make.log) команды make.


![Вывод команды php -i |grep redis](/hw1/lesson_3/part1/make_redis.png)

## 5.2 Установка своего пакета

Клонирование репозитария:

````bash
# git clone https://github.com/petryalta/jstree.git
````

Для установки через Composer, необходимо добавить путь к репозиторию в composer.json

````composer log
"repositories": [
    {
      "type": "github",
      "url": "https://github.com/petryalta/jstree.git"
    }
  ],

````

## 5.3 Создать Docker-образ для работы

Создан [Dockerfile](/hw1/lesson_3/part3/Dockerfile) включающий:
- php 7.4
- xdebug
- redis
- memcached
- http
- pdo_pgsql
- imagik