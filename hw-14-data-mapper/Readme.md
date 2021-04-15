### Конфигурация

Скопировать `hw-14-data-mapper/app/config.example.yml` в `hw-14-data-mapper/app/config.yml`

Прописать нужный конфиг БД

### Лог

`hw-14-data-mapper/app/log/app.log`

### Запрос на запуск сидеров для создания таблиц и данных

```json
{
   "cmd":"seed"
}
```

### Запрос на получение данных

```json
{
  "cmd":"get",
  "params":{
    "limit":"30",
    "offset":"0"
  }
}
```
