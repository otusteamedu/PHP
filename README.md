Утилита для исправления опечаток
===

Утилита `phpfuck`, исправляющая опечатку в команде `php --version`

### Запуск

Запускать можно в docker-образе, в  котором настраивается необходимый алиас

```
docker build -t otus-petrov-aa-hw5-3 .
docker run -d --name otus-petrov-aa-hw5-3 otus-petrov-aa-hw5-3
docker exec -it otus-petrov-aa-hw5-3 bash

php --veion
phpfuck
```
