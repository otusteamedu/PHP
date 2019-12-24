FROM nginx:alpine

RUN apk update && apk add bash nginx tzdata \
    && mkdir -p /var/www/mysite.local && mkdir -p /run/nginx/

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]

