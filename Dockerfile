# Берем образ nginx alpine

FROM nginx:1.17.8-alpine

# Добавляем свой сайт

COPY ./stream /usr/share/nginx/html

# Для запуска использовать build-start.sh