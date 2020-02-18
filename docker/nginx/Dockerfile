FROM nginx:mainline-alpine
WORKDIR /app

RUN addgroup -S -g 3000 app && adduser --uid 3000 -G app -SDH app

RUN rm -rf /etc/nginx/conf.d
COPY ./conf/ /etc/nginx
