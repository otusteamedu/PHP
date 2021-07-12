FROM nginx
WORKDIR /var/www/html

ARG UID
ARG NGINX_PHP_USER

COPY nginx.conf /etc/nginx/nginx.conf
COPY mysite.conf /etc/nginx/conf.d/default.conf
RUN addgroup --gid $UID --system $NGINX_PHP_USER \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID $NGINX_PHP_USER \
  && sed -i -r "s/%REPLACE_USERNAME%/$NGINX_PHP_USER/g" /etc/nginx/nginx.conf