FROM alpine

RUN apk update && apk upgrade && apk add nginx

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf
COPY ./code/* /var/www/


EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
