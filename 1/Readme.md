Основной образ используется ```debian:latest```

Каталог содержит файлы:

```
|--Dockerfile
|--nginx
|  --mysite.conf
|--files
|  --index.html
```
1. Dockerfile - файл, инструкция для docker'a
2. nginx - католог с конфигурационным файлом (mysite.conf) для nginx
3. files - каталог со статическим сайтом, файл index.html

Для работы со статическим сайтом, нужно добавить запись в hosts
```
127.0.0.1 mysite.local
```
Команды для работы с контейнером:
```
docker build -t hw1-1 .                           // создание образа
docker run -d -p 8081:80 hw1-1                    // запуск контейнера с "пробрасыванием портов".
docker stop hw1-1                                 // остановка контейнера
docker container rm hw1-1                         // удаление контейнера
docker image rm hw1-1                             // удаление образа
```

Статический сайт доступен: ```mysite.local:8081```
