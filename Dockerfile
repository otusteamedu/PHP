FROM nginx:stable-alpine
ENV TZ=Europe/Kiev
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
WORKDIR /var/www/html

COPY ./config/nginx/default.conf /etc/nginx/nginx.conf

COPY ./www/html /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]