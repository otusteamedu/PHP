FROM alpine

# установить nginx
RUN apk update && apk add nginx

# пользователь и права
RUN adduser -D -h /home/www -g 'nginx user' www && \
    chown -R www:www /var/lib/nginx && \
    chown -R www:www /home/www

# копирование файлов
COPY ./config/nginx.conf        /etc/nginx/nginx.conf
COPY ./config/deadly.local.conf /etc/nginx/conf.d
COPY ./src/                     /home/www/

# порт
EXPOSE 80

# запуск сервера
CMD ["nginx"]