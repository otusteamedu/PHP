FROM php:7.4-cli-alpine

RUN addgroup -g 3000 app && adduser --uid 3000 -G app -D app && mkdir /socks && chown app:app /socks && chmod 0775 /socks

ARG DEPS="git"
RUN apk add --no-cache $DEPS

ARG DEPS_PHP="xdebug ast intl opcache sockets redis amqp"
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod u+x /usr/local/bin/install-php-extensions && sync && install-php-extensions $DEPS_PHP \
    && rm /usr/local/etc/php/conf.d/*xdebug.ini \
    && mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/app/conf/php/custom.ini /usr/local/etc/php/conf.d/

COPY ./docker/app/conf/rr/rr.yml /usr/local/etc/roadrunner/

WORKDIR /app
RUN chown app:app /app

USER app
RUN echo 'alias c="composer"' >> /home/app/.profile \
    && echo 'alias l="ls -lah"' >> /home/app/.profile

COPY ./docker/app/bin/spiral /home/app/bin/rr

COPY ./composer.* ./
RUN composer install --no-cache --no-dev

COPY --chown=app:app . .
RUN find /app -type d -print0 | xargs -t -0 -P 4 chmod 0755 > /dev/null 2>&1 \
    && find /app -type f -print0 | xargs -t -0 -P 4 chmod 0644 > /dev/null 2>&1

EXPOSE 8000 2113 6001
COPY ./docker-entrypoint.sh /usr/local/bin/
ENTRYPOINT ["docker-entrypoint.sh"]
CMD []
