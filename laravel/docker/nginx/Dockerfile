FROM nginx

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN adduser --disabled-password --gecos "" user

RUN touch /var/run/nginx.pid \
    && chown -Rf user:user \
    /var/cache/nginx \
    /var/log/nginx \
    /var/run/nginx.pid \
    && mkdir /socket \
    && chown user:user /socket