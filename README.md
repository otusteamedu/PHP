Приложение верификации email
===

Приложение принимает запросы на порту 8000. Приложению необходимо передать POST-запрос, содержащий json вида:

```json
{
  "emails": [
    "email1",
    "email2",
    "email3"
  ]
}
```

Ответом будет json - массив содержащий для каждого email результаты 2 проверок: проверка регулярным
выражением, и проверка наличия MX-записи в DNS. Если адрес не прошел проверку на регулярное выражение, то
проверка DNS для него не выполняется. Пример ответа:

```json
[
  {
    "email": "email1",
    "regex": true,
    "dns": false
  },
  {
    "email": "email2",
    "regex": true,
    "dns": true
  },
  {
    "email": "email3",
    "regex": false,
    "dns": false
  }
]
```

### Запуск

```bash
docker-compose build
docker-compose up

curl -X POST --header "Content-Type: application/json" --data "{\"emails\": [\"petrov.aa@phystech.edu\", \"tr1me@mail.ru\", \"tr1me@mail.lol\", \"petrov-aa\"]}" -i 127.0.0.1:8000
```
