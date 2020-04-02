# Домашнее задание №11 (задача №2)

Для хранения данных используется `redis`.

## API для работы с приложением
Для того, чтобы добавить событие в БД, необходимо отправить `POST` запрос на `http://localhost/task2.php`. Пример переменных запроса:
```
action:setevent
conditions:param1=1;param2=2
event:{"data": "1"}
priority:1000
```

Для поиска в БД наиболее подходящего события необходимо отправить `GET` запрос следующего вида `http://localhost/task2.php?action=getevent&params=param1=1;param2=2`.

Для очистки БД от всех введенных ранее событий отправить `POST` запрос на `http://localhost/task2.php` с переменными запроса:
```
action:clearevents
```