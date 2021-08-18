FROM debian:buster-slim
ENV TZ=Europe/Moscow
# ставим необходимые для нормальной работы модули
RUN apt update && apt install -y \
        memcached
# использование порта (default: 11211)
EXPOSE 11211
# запускаем memcached
CMD ["-u", "root", "-m", "128"]
# Устанавливаем пользователя для запуска Set the user to run Memcached daemon
USER daemon
# Устанавливаем entrypoint для memcached binary
ENTRYPOINT memcached
