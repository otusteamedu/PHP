# Это Dockerfile - рецепт для сборки образа (Image). Из него командой docker build мы сделаем образ
# И на основе образа можно будет запускать сколько  угодно контейнеров

# Команда docker build создаёт образ. В docker dashboard появляются контейнеры. Это разные вещи

# Буду собирать из исходного образа alpine. 
# Сюда можно взять любой образ из https://hub.docker.com/ После двоеточия можно указать версию
FROM alpine:latest

# Командой RUN запускаю команду в будующем образе. Эта команда создает новый слой
# В реальной жизни лучше объединять по возможности все RUN в одну команду. С помощью pipe ( "RUN apk update && apk add nginx" )
RUN apk update
RUN apk add nginx

# Создадим папку /run/nginx потому что она необходима для работы nginx но ее нет в новых сборках alpine
RUN mkdir -p /run/nginx

# Создадим папки для настройки домена на nginx
RUN mkdir /var/www/mysite.local/

# Устанавливаем параметры окружения
ENV TZ=Europe/Moscow

# Команда из примера домашки, устанавливает символьную ссылку, мне в принципе не нужна
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Меняем рабочую директорию.
WORKDIR /var/www

# Копируем конфиг nginx в файловую систему образа 
COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

# Ну и содержимое нашего статического сайта
COPY ./files/index.html /var/www/mysite.local/index.html

# Открываем 80ый порт. По умолчанию все порты закрыты
EXPOSE 80

# Команда, массив параметров которые склеятся через пробел. То есть получится "nginx -g daemon off"
# Выполняется для того, чтобы контейнер сразу не отвалился. Потому что если мы напишем просто nginx, то
# nginx запустится в демон режиме в бэкграунде. Докер контейнер подумает что он свою задачу выполнил 
# потому что на foreground он уже ничего не выполняет и просто остановит его. Поэтому важно nginx запустить в режиме
# daemon off 
CMD ["nginx", "-g", "daemon off;"]

# если что на будущее есть готовый образ Nginx на базе alpine тут:  https://hub.docker.com/_/nginx
