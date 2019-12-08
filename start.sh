# Домашнее задание к занятию #3 Поток PHP-2019-11
echo "собираем контейнер с присваиванием тега.\r"
docker build -t otus_hw01_1_static_site:v1 .
echo "запускаем созданный контейнер по тегу.\r"
docker run -d -p 80:80 otus_hw01_1_static_site:v1


# docker container ls -a
# docker stop {{container_id}}
# docker rm {{container_id}}