FROM nginx

COPY nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /usr/src/app/www

COPY app/www/index.html /usr/src/app/www/index.html

WORKDIR /etc/nginx

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
