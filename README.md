# Otus queue

Задание:

Работа с очередью
1. Создать простое веб-приложение, принимающее POST запрос
2. Передать тело запроса в очередь
3. Написать скрипт, который будет читать сообщения из очереди и выводить информацию о них в консоль

## Quick start

1. Запрос POST отправлять на url

http://phpotus.ru/api/queue - домен может быть другой в зависимости от настроек в nginx

## Инструкция по запуску системы

1. Поднять локально RabbitMQ, самый простой вариант в докер 
```bash
docker run -it --rm --name rabbitmq -p 5672:5672 -p 15672:15672 rabbitmq:3-management
```

2. В файле .env указать данные для работы с RabbitMQ (можно не менять, если поднимал RabbitMQ в контейнере как выше)

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


