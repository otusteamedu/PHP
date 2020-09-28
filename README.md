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

***
### Настройка Nginx
```
    server {
      listen 80;
      server_name serviceevent.ru;
      root /Users/ivangluskov/PhpstormProjects/service-event;
      index index.php index.htm;

      location ~ \.php {
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
      }

      location / {
        rewrite ^/$ /api/$1 redirect;
        if (!-e $request_filename){
          rewrite ^/api/(.*)$ /index.php;
        }
      }
    }
```
