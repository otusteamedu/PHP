server {
    # слушаем стандартный порт HTTP
    listen  80;
    # здесь нужно указать наш домен
    server_name myproject.com www.myproject.com;
    # кодировка по умолчанию
    charset utf-8;
    # для разработки потребуются логи
    access_log  /data/myproject.com/logs/access.log combined;
    error_log   /data/myproject.com/logs/error.log;
    # корневая директория логики
    root /data/myproject.com/docs;
    # установим сжатие данных
    gzip on;
    gzip_disable "msie6";
    gzip_comp_level 6;
    gzip_min_length  1100;
    gzip_buffers 16 8k;
    gzip_proxied any;
    gzip_types text/plain application/xml
      application/javascript
      text/css
      text/js
      text/xml
      application/x-javascript
      text/javascript
      application/json
      application/xml+rss;
    # настройки размеров и таймаутов
    client_max_body_size            100m;
    client_body_buffer_size         128k;
    client_header_timeout           3m;
    client_body_timeout             3m;
    send_timeout                    3m;
    client_header_buffer_size       1k;
    large_client_header_buffers     4 16k;
    # правила обработки запросов к домену
    location / {
        # корневая директория
        root /data/myproject.com/docs;
        # стартовый скрипт
        index index.php;
        # правило автозагрузки в порядке следования: файл, папка, скрипт
        try_files $uri $uri/ @fallback;
    }
    # правило для того, чтобы отдавать статические файлы
    location ~* \.(jpeg|ico|jpg|gif|png|css|js|pdf|txt|tar|gz|wof|csv|zip|xml|yml) {
        access_log off;
        try_files $uri @statics;
        expires 14d;
        add_header Access-Control-Allow-Origin *;
        add_header Cache-Control public;
        root /data/myproject.com/docs;
    }
    location @statics {
        rewrite ^/(\w+)/(.*)$ /$2 break;
        access_log off;
        rewrite_log off;
        expires 14d;
        add_header Cache-Control public;
        add_header Access-Control-Allow-Origin *;
        root /data/myproject.com/docs;
    }
    # правила обработки PHP-скриптов
    location ~ \.php$ {
        root /data/myproject.com/docs;
        proxy_read_timeout 120;
        fastcgi_read_timeout 120;
        try_files $uri $uri/ =404;

        # внимательно смотрите на то, какое имя задано у сокета
        # это можно узнать в настройках php-fpm
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
