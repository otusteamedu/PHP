FROM nginx:alpine
WORKDIR /var/www/mysite.local
RUN apk update && apk add bash
ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf
EXPOSE 80
