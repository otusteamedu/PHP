FROM redis

LABEL maintainer="Alexandr Timofeev <tim31al@gmail.com>"

COPY sysctl.conf /etc/
COPY redis.conf /usr/local/etc/redis/redis.conf

CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]
