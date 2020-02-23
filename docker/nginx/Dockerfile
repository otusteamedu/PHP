FROM nginx:mainline-alpine
WORKDIR /app

RUN addgroup -S -g 3000 app && adduser --uid 3000 -G app -SDH app

RUN echo 'alias l="ls -lah"' >> /root/.profile

ARG DEPS="curl"
RUN apk add --no-cache $DEPS

RUN rm -rf /etc/nginx/conf.d
COPY ./conf/ /etc/nginx
