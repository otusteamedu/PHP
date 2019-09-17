FROM php:7.3-fpm as php

RUN apt update && apt install -y \
    git \
    unzip \
    --no-install-recommends

WORKDIR /app/src
COPY . ./

CMD ["php-fpm"]

