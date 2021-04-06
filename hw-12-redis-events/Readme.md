### Конфигурация

Скопировать `hw-12-redis-events/app/config.example.yml` в `hw-12-redis-events/app/config.yml`

### Переключение между хранилищами

```
storage:
  storage_mode: 'redis'
  #storage_mode: 'mongo'
  #db_host: 'mongodb://root:example@mongo:27017'
```

### Папка со структурами в json

`hw-12-redis-events/app/files/structures`


### Лог

`hw-12-redis-events/app/log/app.log`

### Запрос на добавление события

```json
{
   "cmd":"add",
   "params":{
      "event":"test_event",
      "priority":5000,
      "conditions":{
         "param1":"100",
         "param2":"200"
      }
   }
}
```

### Запрос на удаление данных

```json
{
   "cmd":"delete"
}
```

### Запрос списка событий

```json
{
   "cmd":"list"
}
```

### Запрос события по параметрам

```json
{
   "cmd":"search",
   "params":{
      "param1":"100",
      "param2":"200",
      "param_a":"800"
   }
}
```