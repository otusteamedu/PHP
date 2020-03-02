# Инфо

Сборка
```bash
docker build -t app .
```

Варианты запуска
```bash
docker run --rm app example@example.com
cat emails.txt | docker run -i --rm app
```

Возвращает список email'ов с указанием валиден email или нет в виде json. 
```json
{
    "example@example.com": true,
    "john.doe-max+pain@example.com": true,
    "test@gmail.com": true,
    "mail@serverfault.com": false,
    "hello@": false,
    "@test": false,
    "email@gmail": false,
    "problem@test@gmail.com": false,
    "вася@мыло.рф": false
}
```
