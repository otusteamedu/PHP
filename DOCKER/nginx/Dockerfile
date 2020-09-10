FROM alpine:3

ARG DEPS="bash vim nginx curl"
RUN apk update && apk add --no-cache $DEPS

RUN mkdir -p /run/nginx


ENV TZ=Europe/Moscow


# Команда, массив параметров которые склеятся через пробел. То есть получится "nginx -g daemon off"
# Выполняется для того, чтобы контейнер сразу не отвалился. Потому что если мы напишем просто nginx, то
# nginx запустится в демон режиме в бэкграунде. Докер контейнер подумает что он свою задачу выполнил 
# потому что на foreground он уже ничего не выполняет и просто остановит его. Поэтому важно nginx запустить в режиме
# daemon off 
CMD ["nginx", "-g", "daemon off;"]

# если что на будущее есть готовый образ Nginx на базе alpine тут:  https://hub.docker.com/_/nginx
