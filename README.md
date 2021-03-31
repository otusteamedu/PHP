### Хранилища

> Для установки хранилища событий нужно задать `EVENTS_STORAGE`

* `redis` or `elastic`

### Консольные команды

* `event:add {name} {priority} {conditions*}` - создаёт событие.
* `event:delete {--name=} {--all}` - удаляет определённое событие или все
* `event:search {conditions*}` - ищет событие по параметрам

### Примеры

```shell
#Создаём команды
sail artisan event:add test1 1000 param1:1
sail artisan event:add test2 2000 param1:2 param2:2
sail artisan event:add test3 3000 param1:1 param2:2

#Ищем событие (должны получить test3)
sail artisan event:search param1:1 param2:2

#Удаляем событие
sail artisan event:delete --name=test3

#Ищем событие (должны получить test1)
sail artisan event:search param1:1 param2:2

#Удаляем все события
sail artisan event:delete --all

#Ищем событие (ничего не должны получить)
sail artisan event:search param1:1 param2:2
```
