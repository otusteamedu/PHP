# Инфо

Сборка и запуск контейнера
```bash
docker build -t app .
docker run --rm --name app -d app
```

Отправка сообщения
```bash
docker exec app php ./index.php abrakadabra
```

Просмотр логов сервера
```bash
docker logs -t app
```

Остановка и удаление контейнера
```bash
docker rm -f app
```
