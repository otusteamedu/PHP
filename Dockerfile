
# берем образ nginx:alpine
FROM nginx:alpine

# Добавляем Metadata
LABEL maintainer="a.tihomirov@dataduck.com"
LABEL version="1.0"
LABEL description="Это пример докерфайла \
с метаописанием."

# Делаем папку для контента
COPY content /usr/share/nginx/html

# Если нужно поменять конфиг
#COPY conf /etc/nginx

# И ссылку для логов из контейнера
VOLUME /var/log/nginx/log