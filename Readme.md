**Как использовать**
\
\
Везде использовать POST

Для того чтобы добавить event, надо отправить запрос с JSON данными
```json
{
  "request_type": "add",
  "priority": 4000,
  "conditions": ["param1=1", "param2=2", "param3=3"],
  "event": "event_4"
}
```

Для поиск нужно отправить запрос с JSON-данными
```json
{
  "request_type": "search",
  "conditions": ["param1=1", "param2=2", "param3=3"],
}
```

Для удаления нужно отправить запрос с JSON-данными
```json
{
  "type_request": "delete"
}
```
