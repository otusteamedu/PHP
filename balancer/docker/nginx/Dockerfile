FROM nginx

ARG UID
ARG NUM
COPY nginx.conf /etc/nginx/nginx.conf
COPY mysite$NUM.conf /etc/nginx/conf.d/default.conf
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app