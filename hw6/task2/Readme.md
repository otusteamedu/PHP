Устанавливаем зависимости
```bash
cd task2/app
composer install
mv .env.example .env
php artisan key:generate
```

Запускаем докер

```bash
cd task2/docker
docker-compose up
```

Проверяем работу laravel на http://127.0.0.1:8080 
