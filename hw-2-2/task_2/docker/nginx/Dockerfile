FROM nginx
ARG USER_UID

RUN addgroup --gid $USER_UID --system app \
	&& adduser --uid $USER_UID --system --disabled-password --disabled-login --gid $USER_UID app \
	&& touch /var/run/nginx.pid \
	&& chown -Rf app:app \
		/var/run/nginx.pid \
		/var/cache/nginx \
		/var/log/nginx

COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx.conf /etc/nginx/nginx.conf

USER app
