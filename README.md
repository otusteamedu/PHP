### ДЗ 8. Работа с очередью
По адресу http://localhost/ находится страница с которой можно отправить POST запрос.
POST запрос преобразуется в JSON и отправляется в очередь к RabbitMQ.
Приложение состоит из 3 контейнеров Nginx, php-fpm, RabbitMQ и запускается при помощи docker-compose. 
Скрипт, который читает сообщения, запускается локально и находится в `receiver/receiver.php`
Для работы требуется UNIX-подобная ОС, PHP 7.4, docker, docker-compose
#### Установка
`./build.sh`
#### Запуск
`./run.sh` <br>
Отдельно контейнеры `docker-compose up -d`<br>
Отдельно скрипт `php ./receiver/receiver.php`
#### Остановка и удаление контейнеров
`docker-compose down`