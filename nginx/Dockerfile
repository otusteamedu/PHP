FROM nginx
COPY nginx.conf /etc/nginx/nginx.conf
ARG UID
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app