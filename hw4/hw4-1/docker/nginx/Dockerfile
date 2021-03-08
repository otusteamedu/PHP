FROM nginx:stable

RUN apt-get update && apt-get install nano

WORKDIR /var/www/html

VOLUME /var/www/html

CMD ["nginx", "-g", "daemon off;"]