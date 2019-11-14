
Запустить
```sh
$ docker-compose up -d --build
```


Добавить события
```sh
$ curl POST "http://localhost/add.php" -d"name=event1&priority=1000&param1=1"
$ curl POST "http://localhost/add.php" -d"name=event2&priority=2000&param1=2&param2=2"
$ curl POST "http://localhost/add.php" -d"name=event3&priority=3000&param1=1&param2=2"
```

Получить подходящее событие с бОльшим приоритетом
```sh
$ curl POST "http://localhost/check.php" -d"param1=1&param2=2"
```



Очистить все события
```sh
$ curl "http://localhost/flushall.php"
```
