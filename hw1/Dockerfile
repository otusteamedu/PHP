# To build an image
# docker build -t otus .
# To run the container
# docker run --rm -p 8989:80 otus

FROM alpine
RUN apk update && apk add nginx
WORKDIR /srv/www/hw1
RUN adduser -D -g 'Nginx www user' -h /srv/www/hw1/ aaminov
COPY html/. .
EXPOSE 80
COPY static-otus.conf /etc/nginx/conf.d/
CMD ["nginx", "-g", "pid /tmp/nginx.pid; daemon off;"]