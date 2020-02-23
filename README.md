## Запуск приложения

Запускаем ```docker-compose up -d```

заходим под докером, затем в папку socket

устанавливаем зависимости ```composer install```

меняем .env.example на .env и заполняем файл

запуск под сервером ```php index.php --type=server```

запуск под клиентом ```php index.php --type=client```
