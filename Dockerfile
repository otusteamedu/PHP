FROM alpine:edge

RUN apk update && \
	apk upgrade --available && \
	mkdir -p /run/nginx && \	
    apk add nginx tzdata && \
    rm -rf /var/cache/apk/*
    
ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

COPY ./files/index.html /var/www/mysite.local/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]