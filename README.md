# Otus API queue

Задание:

Необходимо реализовать Rest API с использованием очередей. 
Ваши клиенты будут отправлять запросы на обработку, а вы будете складывать их в очередь и возвращать номер запроса. 
В фоновом режиме вы будете обрабатывать запросы, а ваши клиенты периодически, используя номер запроса, будут проверять статус его обработки.

Разрешается
- Использование Composer-зависимостей
- Использование микрофреймворков (Lumen, Silex и т.п.)

## Quick start

1. Запрос POST (на создание задания) отправлять на url

http://phpotus.ru/api/task - домен может быть другой в зависимости от настроек в nginx

2. Запрос GET на получение состояния задачи отправлять 

http://phpotus.ru/api/task/[id задачи]

3. Worker лежит в корне проекта - worker.php

## Инструкция по запуску системы

1. Поднять локально RabbitMQ, самый простой вариант в докер 
```bash
docker run -it --rm --name rabbitmq -p 5672:5672 -p 15672:15672 rabbitmq:3-management
```

2. В файле .env указать данные для работы с RabbitMQ 

3. Подтянуть зависимости c помошью composer
```bash
composer install
```

4. Указать для nginx в файле конфигурации домер, root папку и перенаправление запросов на точку входа index.php, например так
```nginx.conf
      location / {
        rewrite ^/$ /api/$1 redirect;
        if (!-e $request_filename){
          rewrite ^/api/(.*)$ /index.php;
        }
      }
```

5. В файлик добавить строку /etc/hosts (так на mac os и linux думаю)
```
127.0.0.1       phpotus.ru
```


p.s. полный конфиг nginx.conf у меня выглядит так 
```nginx.conf
    server {
      listen 80;
      server_name phpotus.ru;
      root /Users/ivangluskov/PhpstormProjects/otus-queue;
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
