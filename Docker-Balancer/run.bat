@echo off
docker-compose up -d
rem Создаем сертификаты для сайтов
for /F "delims=xxx" %%a in ('docker ps -aq --filter "name=workspace"') do set docker=%%a
docker exec %docker% bash -c "cd /srv/scripts/ && ./start.sh"
rem Вновь запускаем потухший вебсервер.
docker-compose up -d webserver