# PHP

### Поднять RedisJson
```bash
docker run -p 6379:6379 --name redis-redisjson redislabs/rejson:latest
```

### Получить все события:
method - GET
url - http://serviceevent.ru/api/event/

### Создать событие:
method - POST
url - http://serviceevent.ru/api/event/

body
```json
{
    "priority": 4000,
    "conditions": {
        "param1": "hello",
        "param2": "123"
    }
}
```

### Найти событие с условием и максимальным приоритетом:
method - PUT
url - http://serviceevent.ru/api/event/

body
```json
{
    "params": {
        "param1": "hello",
        "param2": "123"
    }
}
```

### Удалить все события:
method - DELETE
url - http://serviceevent.ru/api/event/
