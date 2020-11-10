# Задание 1:
Через Dockerfile

Находясь в папке from_dockerfile собираем образ с помощью команды:
docker build . -t image_hw_1_1_nginx

Далее запускаем контейнер:
docker run -d --name=hw1_1_1 -p 8080:80 -v $PWD/code:/var/www/html/testsite:rw image_hw_1_1_nginx
Запускаю из под убунты поэтому использую просто $PWD

Единственный момент при запуске контейнера nginx подхватывает дефолтный конфиг и не открывает testsite до тех пор пока я не удалю /etc/nginx/site-enabled/default.
После его удаления и перезапуска контейнера все работает.
