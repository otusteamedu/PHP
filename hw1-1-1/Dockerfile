FROM debian

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
	apt-get -y install nginx \
	vim

RUN mkdir -p /var/www/site.local
WORKDIR /var/www/site.local

COPY nginx/site.conf /etc/nginx/sites-enabled/site.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]