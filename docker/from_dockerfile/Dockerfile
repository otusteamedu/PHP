FROM debian

RUN apt-get update \
	&& apt-get install -y nginx

ENV TZ=Asia/Yekaterinburg

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./conf/nginx/hosts/testsite.local.conf /etc/nginx/sites-enabled/testsite.local.conf

WORKDIR /var/www/html/testsite

VOLUME /var/www/html/testsite

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
