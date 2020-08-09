server {

    listen  80;
    server_name otus-lessons.com *.otus-lessons.com;

    charset utf-8;

    access_log  /data/otus-lessons/logs/access.log combined;
    error_log   /data/otus-lessons/logs/error.log;

    root /home/vagrant/mount;

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

    client_max_body_size            100m;
    client_body_buffer_size         128k;
    client_header_timeout           3m;
    client_body_timeout             3m;
    send_timeout                    3m;
    client_header_buffer_size       1k;
    large_client_header_buffers     4 16k;

    # правила обработки запросов к домену
    location / {
        root /home/vagrant/mount/;

        index index.php;

        try_files $uri $uri/ @fallback;
    }

    location ~ \.php$ {
        root /home/vagrant/mount/;
        proxy_read_timeout 120;
        fastcgi_read_timeout 120;
        try_files $uri $uri/ =404;
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
