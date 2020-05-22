FROM nginx:alpine

RUN apk update \
	&& apk upgrade;

COPY ./default.conf /etc/nginx/conf.d/
COPY ./index.html /var/www/index.html

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
