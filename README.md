Инструкция по разворачиванию приложения. 

1) Создать файлы .env по формам .env.example в папках:
  - docker/database
  - docker/rabbit-mq
  - app

2) Инициализация докер контейнеров
```apacheconf
cd docker 
docker-compose up -d
```

3) Запуск RabbitMQ
```
docker-compose run --rm app-cli php /app/app.loc/src/index.php rabbit-run
```

4) Форма для запроса асинхронного отчета по адресу /films/report.
