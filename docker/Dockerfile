FROM alpine

RUN apk update && apk add nginx && apk add tzdata \
    && mkdir -p /var/www/mysite.local && mkdir -p /run/nginx/

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./conf/nginx/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
