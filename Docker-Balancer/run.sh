docker-compose up -d
# Создаем сертификаты для сайтов
dockerID=$(docker ps -aq --filter "name=workspace")
docker exec $dockerID bash -c "cd /srv/scripts/ && ./start.sh"
# Вновь запускаем потухший вебсервер.
docker-compose up -d webserver
