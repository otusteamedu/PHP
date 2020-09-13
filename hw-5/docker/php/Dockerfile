FROM php:7.4-fpm

# Install dev dependencies

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html
COPY docker-entrypoint.sh /usr/bin/docker-entrypoint.sh
RUN chmod +x /usr/bin/docker-entrypoint.sh

ARG UID
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

ARG SOCKET
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
RUN sed  -i "s/docker.sock/$SOCKET.sock/" /usr/local/etc/php-fpm.d/zz-docker.conf

ENTRYPOINT ["/usr/bin/docker-entrypoint.sh"]
