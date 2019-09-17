### Docker образ php-fpm 7.3 и необходимые модули
Собираем образ:  
```
$ docker build -t otus-php-fpm:latest otus-php-fpm
```

Запускаем:  
```
$ docker run --rm -d --name otus-php-fpm otus-php-fpm:latest
```
