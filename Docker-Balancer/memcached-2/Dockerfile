FROM debian:buster-slim
ENV TZ=Europe/Moscow
# ставим необходимые для нормальной работы модули
RUN apt update && apt install -y \
        wget \
        gcc \
        make \
        memcached \
        libevent-dev
# временно устанавливаем рабочую директорию
WORKDIR /tmp

# копируем заплатку и bash скрипт запуска
COPY ./conf/repcache/memcached.c /tmp/memcached.c
COPY ./conf/repcache/memcachedrep.sh /etc/init.d/memcachedrep.sh
COPY ./conf/repcache/memcachedrep /etc/default/memcachedrep

# Устанавливаем Repcached+Memcached
RUN wget https://sourceforge.net/projects/repcached/files/repcached/2.2.1-1.2.8/memcached-1.2.8-repcached-2.2.1.tar.gz \
	&& tar xvf memcached-1.2.8-repcached-2.2.1.tar.gz \
    && cp memcached.c /tmp/memcached-1.2.8-repcached-2.2.1/memcached.c \
	&& cd memcached-1.2.8-repcached-2.2.1 \
    && ./configure --enable-replication \
	&& make \
	&& make install

# окончательно устанавливаем рабочую директорию
WORKDIR /etc/init.d

EXPOSE 11211
# запускаем memcached

CMD ["/etc/init.d/memcachedrep.sh", "start"]
# Устанавливаем пользователя для запуска Set the user to run Memcached daemon
USER daemon
# Устанавливаем entrypoint для memcached binary
ENTRYPOINT memcached
