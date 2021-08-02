FROM debian:buster-slim
ENV TZ=Europe/Moscow
# ставим необходимые для нормальной работы модули
RUN apt update && apt install -y \
        wget \
        gcc \
        make
# временно устанавливаем рабочую директорию
WORKDIR /tmp
# Устанавливаем REDIS
RUN wget http://download.redis.io/redis-stable.tar.gz \
	&& tar xvzf redis-stable.tar.gz \
	&& cd redis-stable \
	&& make \
	&& make install
# окончательно устанавливаем рабочую директорию
WORKDIR /usr/local
CMD ["redis-server", "./etc/redis/redis.conf"]