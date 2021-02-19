FROM nginx
RUN apt-get update && apt-get install nano
COPY ./hosts/otus-docker.conf /etc/nginx/conf.d/default.conf
WORKDIR /code 
VOLUME /code 
CMD ["nginx", "-g", "daemon off;"]
