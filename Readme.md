Docker-compose запускает 4 контейнера, один из них composer, который заканчивает после выполнения composer install.
1 c Redis, 1 - php-fpm и 1 - nginx.

Взаимодействие с приложением выполняется методом POST

Для добавления нужно отправить JSON-данные
```json
{
  "type_request": "add",
  "priority": 4000,
  "conditions": ["param1=1", "param2=2", "param3=3"],
  "event": "event_4"
}
```

Для поиск нужно отправить JSON-данные
```json
{
  "type_request": "get_item",
  "conditions": ["param1=1", "param2=2", "param3=3"],
}
```

Для удаления нужно отправить JSON-данные
```json
{
  "type_request": "delete",
}
```
