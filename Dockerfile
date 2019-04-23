FROM nginx:alpine

# Копируем конфиг nginx
COPY nginx/nginx.conf /etc/nginx/nginx.conf

# Копирум код приложения
COPY www /app
