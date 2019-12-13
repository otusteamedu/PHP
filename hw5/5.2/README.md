#### Запуск проекта

1. docker-compose up -d    
2. docker-compose exec php composer clear-cache --no-interaction    
3. docker-compose exec php composer install --no-interaction    

#### Проверка скобок

Откройте браузер и введите адрес с параметром 'string'. Можно попробовать следующие варианты:    
    
    localhost/?string=)(     
    localhost/?string=(()))    
    localhost/?string=(()         
    localhost/?string=()   