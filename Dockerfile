
# берем образ nginx:alpine
FROM nginx:alpine

# Добавляем Metadata
LABEL maintainer="a.tihomirov@dataduck.com" version="1.0" description="Это пример докерфайла с метаописанием."

# Делаем папку для контента
COPY content /usr/share/nginx/html

# И ссылку для логов из контейнера
VOLUME /var/log/nginx/log