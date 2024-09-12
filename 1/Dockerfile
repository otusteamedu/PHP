FROM debian

RUN apt-get update && apt-get install -y locales \
    && apt-get install -y nginx

COPY nginx/mysite.conf /etc/nginx/site-enabled/mysite.conf
COPY files/index.html /var/www/html/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]