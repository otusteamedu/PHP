FROM alpine:edge

ENV TZ=Europe/Moscow

RUN apk update && \
	apk upgrade --available && \
	mkdir -p /run/nginx && \	
    apk add nginx tzdata
    
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./conf/nginx/hosts/alma.pirata.conf /etc/nginx/sites-enabled/alma.pirata.conf

COPY ./files/index.html /var/www/alma.pirata/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]