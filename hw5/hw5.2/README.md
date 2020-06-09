### Запуск проекта

```php
cp .env.test .env
docker-compose up --build -d
cd app
cp .env.test .env
```

Чтобы войти в любой из контейнеров, делаем следующее:
```php
docker exec -it <container_name> bash
```

Логи контейнера:
```php
docker logs <container_name>
```
