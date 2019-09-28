## Запуск  

Сборка и запуск контейнеров nginx и php:  
```
# docker-compose up -d --build
```

## Проверка скрипта валидации скобок:  

```
curl -d "string=()()" -H "Content-Type: application/x-www-form-urlencoded" http://localhost/ -i
```
```
curl -d "string=()())" -H "Content-Type: application/x-www-form-urlencoded" http://localhost/ -i
```
