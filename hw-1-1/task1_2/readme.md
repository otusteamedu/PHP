# deploy with docker-compose
```
# cd hw-1-1/task1_2/

cp code/.env.example code/.env

cp .env.example .env

docker-compose up -d

#docker-compose stop
#docker-compose down
```

# deploy with docker
```
# cd hw-1-1/task1_2/

cp code/.env.example code/.env

cp .env.example .env
source .env

docker pull mysql

docker build -t hw_1_1/php ./php-fpm
docker build -t hw_1_1/nginx ./nginx

docker network create -d bridge hw-1-1-net

docker run --name hw_1_1_db_container \
     -e MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD \
     -e MYSQL_DATABASE=$MYSQL_DATABASE \
     -v $(pwd)/../../logs/dbdata:/var/lib/mysql \
     -v $(pwd)/../../logs/mysql-log:/var/log/mysql \
     -d \
     -p $DB_PORT:3306 \
     --network=hw-1-1-net \
     --rm \
     mysql \
     --default-authentication-plugin=mysql_native_password

docker run --name hw_1_1_php_fpm_container \
     -v $(pwd)/code:/data/site.default \
     -d \
     --network=hw-1-1-net \
     --rm \
     hw_1_1/php

docker run --name hw_1_1_nginx_container \
     -v $(pwd)/../../logs/nginx-log:/var/log/nginx \
     -d \
     -p $APP_PORT1:80 \
     -p $APP_PORT2:443 \
     --network=hw-1-1-net \
     --rm \
     hw_1_1/nginx

## stop containers
# docker stop hw_1_1_db_container hw_1_1_php_fpm_container hw_1_1_nginx_container
```

# deploy with Homestead
[Installing/Configuring Homestead](https://laravel.com/docs/8.x/homestead#installing-homestead)
```
# cd hw-1-1/task1_2/

cp code/.env.example-homestead code/.env

cp Homestead.yaml.example Homestead.yaml

# modify Homestead/Vagrantfile like: homesteadYamlPath = "/home/bo/otus/PHP-repo/hw-1-1/task1_2/Homestead.yaml"

# add record to /etc/hosts
sudo bash -c "echo \"192.168.10.11 homestead.hw.1.1\" >> /etc/hosts"

# cd to dir with Vagrantfile - cd /home/bo/otus/Homestead
vagrant up

# index.php - max priority
vagrant ssh
# see example: homestead.conf.example
sudo nano /etc/nginx/sites-available/homestead.hw.1.1
# modify like `index index.php index.html index.htm;`
sudo systemctl restart nginx
exit

# vagrant halt - stop VM
# vagrant destroy - remove VM
```


# other commands, examples

## build image
docker build -t <image-name> <path-to-dir-with-Dockerfile>
## pull image (from dockerhub)
docker pull <image-name>
## build network
docker network create --driver=bridge <network-name>
## run container
docker run --rm -d \
    -p <host-port>:80 \
    -v <absolute-path-to-src-on-host>:<absolute-path-to-src-in-container> \
     --name <container-name> \
     --network=<network-name> \
     <image-name>
     
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
