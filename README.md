Домашнее задание №5
==========================
Оркестрация, fpm и nginx через socket, установка Laravel
--------------------------

### Часть 1. Оркестрация, fpm и nginx через socket

Приложение имеет два контейнера. Взаимодействие меожду ними описано в ```docker-compose.yml```.

#### Описание архитектуры:

```./part-1/docker/images``` — образы контейнеров nginx и php.

```./part-1/docker/conf``` — файлы настроек для сервисов в контейнерах.

```./part-1/docker/logs``` — директория служебная и необходима для хранения логов обращений к nginx и логов ошибок.
  
```./part-1/docker/socket``` — директория для хранения файла .sock.

```./part-1/public``` — директория для публичного доступа к приложению.

```./part-1/src``` — директория для хранения логики приложения.

#### Запуск приложения

```bash
cd part-1
docker-compose up -d
```
#### Проверка работы приложения

Примеры обращений к приложению:
```bash
ruslan@Ruslans-MacBook-Pro part-1 % curl -i --http1.1 -H "Content-Type: application/x-www-form-urlencoded" -X POST -d "string=(()()()()))((((()()()))(()()()(((()))))))" http://127.0.0.1
HTTP/1.1 400 Bad Request
Server: nginx/1.17.9
Date: Fri, 29 May 2020 19:05:57 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.18

Brackets sequence is not valid

curl -i --http1.1 -H "Content-Type: application/x-www-form-urlencoded" -X POST -d "string=)(" http://127.0.0.1
HTTP/1.1 400 Bad Request
Server: nginx/1.17.9
Date: Fri, 29 May 2020 19:14:52 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.18

Brackets conflict

ruslan@Ruslans-MacBook-Pro part-1 % curl -i --http1.1 -H "Content-Type: application/x-www-form-urlencoded" -X POST -d "string=" http://127.0.0.1
HTTP/1.1 400 Bad Request
Server: nginx/1.17.9
Date: Fri, 29 May 2020 19:07:48 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.18

String parameters is empty

ruslan@Ruslans-MacBook-Pro part-1 % curl -i --http1.1 -H "Content-Type: application/x-www-form-urlencoded" -X POST http://127.0.0.1 
HTTP/1.1 400 Bad Request
Server: nginx/1.17.9
Date: Fri, 29 May 2020 19:08:47 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.18

No parameters to check

ruslan@Ruslans-MacBook-Pro part-1 % curl -i --http1.1 -H "Content-Type: application/x-www-form-urlencoded" -X GET -d "string=()" http://127.0.0.1
HTTP/1.1 405 Method Not Allowed
Server: nginx/1.17.9
Date: Fri, 29 May 2020 19:09:09 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.18

Invalid Method

ruslan@Ruslans-MacBook-Pro part-1 % curl -i --http1.1 -H "Content-Type: application/x-www-form-urlencoded" -X POST -d "string=(()())()" http://127.0.0.1
HTTP/1.1 200 OK
Server: nginx/1.17.9
Date: Fri, 29 May 2020 19:12:27 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.18

Brackets sequence is valid

ruslan@Ruslans-MacBook-Pro part-1 % curl -i --http1.1 -H "Content-Type: application/x-www-form-urlencoded" -X POST -d "string=()" http://127.0.0.1
HTTP/1.1 200 OK
Server: nginx/1.17.9
Date: Fri, 29 May 2020 19:16:06 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.18

Brackets sequence is valid
```

#### Остановка приложения
```bash
docker-compose down
```

### Установка Laravel

Установка и первичная настройка на окружении прошла успешно. Проект находится в директории ```./part-2/blog```. 

[Скриншот стартовой страницы](https://github.com/otusteamedu/PHP/blob/RMaysak/hw5/part-2/laravel.png?raw=true).