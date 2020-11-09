# deploy with docker-compose
```
cp .env.example .env
docker-compose up -d
```

# deploy with Homestead
[Installing/Configuring Homestead](https://laravel.com/docs/8.x/homestead#installing-homestead)
```
cp Homestead.yaml.example Homestead.yaml

# modify Homestead/Vagrantfile like: homesteadYamlPath = "/home/bo/otus/PHP-repo/Homestead.yaml"

# add record to /etc/hosts
sudo bash -c "echo \"192.168.10.11 homestead.test\" >> /etc/hosts"

vagrant up
# vagrant halt - stop VM
# vagrant destroy - remove VM

# index.php - max priority
vagrant ssh
sudo nano /etc/nginx/sites-available/homestead.test
# modify like index.php index index.html index.htm;
exit
# reload
```


# deploy with DOCKER

## build images
docker build -t <image-name> <path-to-dir-with-Dockerfile>
```
docker build -t app2-nginx-image ./nginx
docker build -t app2-phpfrm-image ./php-fpm
```
## pull images (from dockerhub)
docker pull <image-name>
```
docker pull mysql:5.7.22
```
## build network
docker network create --driver=bridge <network-name>
```
docker network create --driver=bridge app2-net
```
## run containers
docker run --rm -d \
    -p <host-port>:80 \
    -v <absolute-path-to-src-on-host>:<absolute-path-to-src-in-container> \
     --name <container-name> \
     --network=<network-name> \
     <image-name>
```
docker run --rm -d -p 8000:80 -v $(pwd)/src:/usr/share/nginx/html --name html-nginx-container html-nginx-image

# container with database
docker run --name db_container \
     -e MYSQL_ROOT_PASSWORD=mysql_root_password \
     -e MYSQL_DATABASE=database_name \
     -d \
     -p 3315:3306 \
     --network=app2-net \
     --rm \
     mysql:5.7.22

# container with php-fpm
docker run --name php_fpm_container \
     -v $(pwd)/code:/data/site.default \
     -d \
     --network=app2-net \
     --rm \
     app2-phpfrm-image

# container with nginx
docker run --name nginx_container \
     -d \
     -p 93:80 \
     --network=app2-net \
     --rm \
     app2-nginx-image
```


# other commands, examples

## explore container / service inside
docker exec -it <container-name> bash

docker-compose exec <service-name> bash


## list of images
docker images

## list of containers
docker ps -a

## stop container
docker stop html-nginx-container

## remove container
docker container rm html-nginx-container

## remove image
docker rmi html-nginx-image

## remove all unused containers, networks, images (both dangling and unreferenced), and optionally, volumes.
docker system prune

## stop and remove all containers
docker stop $(docker ps -a -q) && docker rm $(docker ps -a -q)

## docker-compose
```
docker-compose ps - list of running services
docker-compose build - build/rebuild
docker-compose up [-d]
docker-compose stop
docker-compose down - remove
```
