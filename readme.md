## build image
docker build -t <image-name> <path-to-dir-with-Dockerfile>

example: docker build -t html-nginx-image .
```
-t html-nginx-image - name of image
```

## run container
docker run --rm -d -p <host-port>:80 -v <absolute-path-to-src>:/usr/share/nginx/html --name <container-name> <image-name>

example: docker run --rm -d -p 8000:80 -v $(pwd)/src:/usr/share/nginx/html --name html-nginx-container html-nginx-image
```
--rm - automatically remove container after stopping
-d - launch container as demon
-p 8010:80 -> browser: localhost:8010
-v /home/bo/code:/usr/share/nginx/html - sync dir with code
--name html-nginx-container - name of container
html-nginx-image - basic image for container
```

## use docker-compose
```
cp .env.example .env
docker-compose up -d
```


## other commands, examples

### list of images
docker images

### list of containers
docker ps -a

### stop container
docker stop html-nginx-container

### remove container
docker container rm html-nginx-container

### remove image
docker rmi html-nginx-image

### remove all unused containers, networks, images (both dangling and unreferenced), and optionally, volumes.
docker system prune

### stop and remove all containers
docker stop $(docker ps -a -q) && docker rm $(docker ps -a -q)

### docker-compose
```
docker-compose ps - list of running services
docker-compose build - build/rebuild
docker-compose up [-d]
docker-compose stop
docker-compose down - remove
```
