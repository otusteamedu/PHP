# deploy with docker-compose
```
# cd <path-to-repo>
cp .env.example .env
docker-compose up -d
```

# deploy with docker
```
# cd <path-to-repo>

cp .env.example .env
source .env

docker pull mysql

docker build -t app2-nginx-image ./nginx
docker build -t app2-phpfrm-image ./php-fpm

docker network create --driver=bridge app2-net

docker run --name db_container \
     -e MYSQL_ROOT_PASSWORD=$MYSQL_ROOT_PASSWORD \
     -e MYSQL_DATABASE=$MYSQL_DATABASE \
     -v $(pwd)/dbdata:/var/lib/mysql \
     -v $(pwd)/mysql-log:/var/log/mysql \
     -d \
     -p $DB_PORT:3306 \
     --network=app2-net \
     --rm \
     mysql \
     --default-authentication-plugin=mysql_native_password

docker run --name php_fpm_container \
     -v $(pwd)/code:/data/site.default \
     -d \
     --network=app2-net \
     --rm \
     app2-phpfrm-image

docker run --name nginx_container \
     -v $(pwd)/nginx-log:/var/log/nginx \
     -d \
     -p $APP_PORT1:80 \
     -p $APP_PORT2:443 \
     --network=app2-net \
     --rm \
     app2-nginx-image

## stop containers
# docker stop db_container php_fpm_container nginx_container
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
sudo nano /etc/nginx/sites-available/homestead.php
# modify like `index index.php index.html index.htm;`
exit

sudo systemctl restart nginx

# modify code/index.php (uncomment 10 - 13 lines)
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
