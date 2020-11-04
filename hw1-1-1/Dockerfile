FROM debian

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
	apt-get -y install nginx \
	vim

RUN mkdir -p /var/www/site.local
WORKDIR /var/www/site.local

COPY nginx/site.conf /etc/nginx/sites-available/site.conf
RUN ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf
COPY site.local/index.html /var/www/site.local/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]