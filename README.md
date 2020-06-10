# Задание

API

Цель: Научиться создавать универсальный интерфейс для различных потребителей
(frontend фреймворки, мобильные приложения, сторонние приложения)

Используя мини-приложение, разработанное в прошлом модуле, необходимо реализовать Rest API с использованием очередей.
Ваши клиенты будут отправлять запросы на обработку, а вы будете складывать их в очередь и возвращать номер запроса.
В фоновом режиме вы будете обрабатывать запросы, а ваши клиенты периодически, используя номер запроса,
будут проверять статус его обработки.

Критерии оценки:

1. Stateless схема работы
2. Работа с очередью с возможностью замены решения очереди
3. Желательно привести пример работы API на нескольких серверах с балансировкой

# Использование

Подготовка:
```bash
cp config.example.php config.php
docker-compose -f docker-compose.test.yml build
docker-compose -f docker-compose.test.yml up -d
```

Постановка задачи в очередь:
```bash
curl -X POST localhost/task/set --header 'Content-Type: application/json' -d '{"data": "test"}'
# {"id":"5fb793fd167071e9de0a2205494d5efb"}
```

Получение результата:
```bash
curl -X POST localhost/task/get --header 'Content-Type: application/json' -d '{"id": "5fb793fd167071e9de0a2205494d5efb"}'
# {"status":"done"}
# метод не идемпотентный, следующие запросы вернут `{"status":"not_found"}`
```

Обработку очереди можно остановить:
```bash
docker-compose exec app composer j:stop
``` 

Запустить:
```bash
docker-compose exec app composer j:start
``` 

Статистика:
```bash
docker-compose exec app composer j:stat
``` 
