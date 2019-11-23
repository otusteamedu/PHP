FROM php:7.3-fpm

ARG GIT_EMAIL
ARG GIT_NAME

# tools
RUN \
    apt-get update \
    && apt-get install apt-utils -y \
    && apt-get install git zip unzip -y \
    && apt-get clean

# got config
RUN \
    git config --global user.email "${GIT_EMAIL}" \
    && git config --global user.name "${GIT_NAME}"

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR "/opt/project"

# Laravel
RUN composer create-project --prefer-dist laravel/laravel blog

EXPOSE 9000

CMD ["php-fpm"]