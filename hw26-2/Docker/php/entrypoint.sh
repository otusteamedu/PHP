#! /bin/bash

composer install
while ! nc -z rabbitmq 5672; do sleep 3; echo 'waiting for rabbitmq start'; done
php /code/src/rabbitmq/worker.php &
php /code/src/rabbitmq/worker.php &
php /code/src/rabbitmq/worker.php &
php-fpm