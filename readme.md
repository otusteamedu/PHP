# Как поднять статический сайт с помощью Docker

### Собираем образ из Dockerfile
Перемещаемся в папку с `Dockerfile` и делаем. Либо указываем полный путь до докер файла после -t 
```
docker build -t static-html .
```
где static-html - <build-directory>

### Проверяем:
```
docker images
```
Видим что-то типа:

REPOSITORY | TAG | IMAGE ID | CREATED | SIZE |
--- | --- | --- | --- | ---
static-html  |      latest     |         b89d815f1d27     |   56 seconds ago   |   21.2MB
nginx        |       alpine    |          d87c83ec7a66    |    2 weeks ago     |    21.2MB


### Собираем из образа, запускаем контейнер. 
Что бы обращаться к контейнеру не по ID, необходимо задать ему имя --name <container-name>. Поскольку это веб сервер нужно привязать 80 порт к порту контейнера. Указываем -p <host-port>:<container-port>. Ну и имя образа. 
	
```
docker run -d --name static-html -p 80:80 static-html
```

docker container ls

CONTAINER ID   |     IMAGE      |         COMMAND       |           CREATED      |       STATUS      |        PORTS      |         NAMES |
--- | --- | --- | --- | --- | --- | ---
e1340fd32977    |    static-html    |     "nginx -g 'daemon of…"  | 15 minutes ago   |   Up 12 minutes   |    0.0.0.0:80->80/tcp |  static-html|

Видим что наш контейнер запустился

### Останавливаем контейнер
```
docker stop static-html
```

### Запускаем контейнер снова 
```
docker start static-html
```