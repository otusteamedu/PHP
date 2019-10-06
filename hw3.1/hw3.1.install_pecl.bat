@rem Домашнее задание №3
@rem Установка php-расширений xdebug и redis через pecl

@rem Запускается контейнер.
@rem В контейнере запускается заранее подготовленный скрипт для установки расширений.
@rem После установки происходит выход из контейнера.

@docker images | findstr 7.3-fpm-alpine
@if not "%ERRORLEVEL%"=="0" (
    docker pull php:7.3-fpm-alpine
)

set shellScript=hw3.1.install_pecl.sh
docker run -d --rm --name hw3.1 -it php:7.3-fpm-alpine
docker cp %shellScript% hw3.1:/var/www/html/
docker exec -it hw3.1 sh -c "chmod 744 %shellScript% && ./%shellScript%"
