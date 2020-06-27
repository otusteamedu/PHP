FROM tarantool/tarantool-nginx:latest


RUN addgroup -g 3000 -S app
RUN adduser -u 3000 -S -D -G app app
RUN adduser -u 3001 -S -D -G app app2
# RUN rc-service crond start && rc-update add crond

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /usr/src/mysite.local

