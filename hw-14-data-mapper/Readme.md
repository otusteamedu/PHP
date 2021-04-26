### Конфигурация

Скопировать `hw-14-data-mapper/app/config.example.yml` в `hw-14-data-mapper/app/config.yml`

Прописать нужный конфиг БД

### Миграции и сидеры

К проекту подключен phinx, чтобы запустить миграцию на создание таблицы films нужно выполнить команду

`vendor/bin/phinx migrate`

Чтобы заполнить таблицу фейковыми записями, нужно запустить сидер

`php vendor/bin/phinx seed:run`

### Лог

`hw-14-data-mapper/app/log/app.log`

### POST-запрос на получение данных (передавать в поле "q")

```json
{
  "cmd":"get",
  "params":{
    "limit":"30",
    "offset":"0"
  }
}
```
