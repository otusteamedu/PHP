# docker install
sudo apt update
sudo apt install apt-transport-https ca-certificates curl software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu focal stable"
sudo apt update
apt-cache policy docker-ce
sudo apt install docker-ce
sudo systemctl status docker
sudo usermod -aG docker ${USER}
su - ${USER}

# docker-compose install
sudo curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose --version

# docker-compose run
docker-compose build app
docker-compose up -d
docker-compose ps
#docker-compose exec
#docker-compose pause
#docker-compose unpause
#docker-compose down

# docker commands
# docker ps
# docker build
# docker run -d
# docker kill
# docker rm
# docker rmi
# docker images