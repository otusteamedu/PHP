# Как поднять статический сайт с помощью Docker

### Собираем образ из Dockerfile
Перемещаемся в папку с `Dockerfile` и делаем
```
docker build -t static-site .
```

### Собираем из образа, запускаем контейнер и мапим локальный порт 8080 на 80 порт контейнера
Собираем контейнер с именем, чтобы не искать каждый раз его плохо запоминаемый ID
```
docker run --name nginx-static-site -p 8080:80 static-site:latest
```

### Останавливаем контейнер
```
docker stop nginx-static-site
```

### Запускаем контейнер снова 
```
docker start nginx-static-site
```