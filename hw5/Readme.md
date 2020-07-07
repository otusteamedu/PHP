
##### 1. Простое веб-приложение в docker

Запускаем контейнеры

    docker-compose up

Заходим в контейнер

    docker exec -it -u www-data hw5_1-php-fpm bash    
    
Устанавливаем зависимости

    composer install

Сервис доступен по ссылке

    http://localhost:8080/
    
При желании можно включить форму, чтобы отправить POST-запрос
    
    http://localhost:8080?form    
    
##### 2. Развернуть базовую установку Laravel

Запускаем контейнеры

    docker-compose up

Заходим в контейнер

    docker exec -it -u www-data hw5_2-php-fpm bash      
    
Устанавливаем Laravel если еще не установлен

    composer create-project --prefer-dist laravel/laravel . "5.8.*"
    
Сайт доступен по ссылке

    http://localhost:8080/