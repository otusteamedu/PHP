FROM nginx

ARG UID
COPY nginx.conf /etc/nginx/nginx.conf
COPY mysite.conf /etc/nginx/conf.d/default.conf
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app