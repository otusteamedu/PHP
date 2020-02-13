Add hosts:
127.0.0.1   app.local
127.0.0.1   laravel.local

Create .env from .env.example

### Запрос

```http request 
http://app.local/
POST / HTTP/1.1
Content-Type: application/x-www-form-urlencoded

string: (()()()()))((((()()()))(()()()(((()))))))
```

### Ответ

```json
{
    "status": "ok",
    "result": "String: {string} is valid"
}
```

### В случае ошибки

```json
{
    "status": "error",
    "message": "Текст ошибки"
}
```
