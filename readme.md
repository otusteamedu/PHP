Add hosts:
127.0.0.1   app.local

Create .env from .env.example

### Запрос

```http request 
http://app.local/
GET / HTTP/1.1

email: test@gmail.com
```

### Ответ

```json
{
    "status": "ok",
    "result": "{email} is valid",
    "ip": "IP node"
}
```

### В случае ошибки

```json
{
    "status": "error",
    "message": "Текст ошибки"
}
```
