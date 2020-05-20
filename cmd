cd ~/PhpstormProjects/PHP
docker ps -a
docker build -t eapdob/myproject-nginx --file ./DockerFileNginx/Dockerfile . | tee docker.log
docker build -t eapdob/myproject --file ./DockerFilePhp/Dockerfile . | tee docker.log
docker build -t eapdob/myproject-postgresql --file ./DockerFilePostgresql/Dockerfile . | tee docker.log
docker images
docker push eapdob/myproject:latest
docker push eapdob/myproject-nginx:latest
docker push eapdob/myproject-postgresql:latest
docker-compose up -d