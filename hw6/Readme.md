
##### 1. Приложение верификации email

Запускаем контейнеры

    docker-compose up

Заходим в контейнер

    docker exec -it -u www-data hw6_1-php-fpm bash    
    
Устанавливаем зависимости

    composer install

Сервис доступен по ссылке

    http://localhost:8080/
       
##### 2. Балансировщик nginx-upstream

Запускаем контейнеры

    docker-compose up
    
Сайт доступен по ссылке

    http://localhost:8080/