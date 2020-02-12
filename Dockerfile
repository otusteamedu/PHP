FROM nginx
MAINTAINER RVelibegov <velibegov@mail.ru>
COPY ./files/index.html /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]