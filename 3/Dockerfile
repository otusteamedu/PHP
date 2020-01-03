#VERSION php image
ARG BASEIMAGE_VERION="7.3-fpm-buster"
FROM php:${BASEIMAGE_VERION} as php73

#Parameters this image
ARG DOCKER_USERNAME_ARG="web"
ARG LOCALE_CHARSET_ARG="UTF-8"
ARG LOCALE_LANGUAGE_ARG="ru_RU"
ARG TZ_ARG="Europe/Moscow"

#Environment
ENV TZ_ENV=${TZ_ARG}
ENV LOCALE_CHARSET_ENV=${LOCALE_CHARSET_ARG}
ENV LOCALE_LANGUAGE_ENV=${LOCALE_LANGUAGE_ARG}
ENV LANG=C.${LOCALE_CHARSET_ENV} LC_ALL=C.${LOCALE_CHARSET_ENV}
ENV DOCKER_USERNAME_ENV=${DOCKER_USERNAME_ARG}
ENV ROOT_USERNAME_ENV="root"
ENV DOCKER_WORKDIR_ENV=/home/${DOCKER_USERNAME_ENV}

USER ${ROOT_USERNAME_ENV}:${ROOT_USERNAME_ENV}

# Add group and user
RUN groupadd --gid 1000 ${DOCKER_USERNAME_ENV} && \
    adduser --uid 1000 --home /home/${DOCKER_USERNAME_ENV} --shell /bin/bash --ingroup ${DOCKER_USERNAME_ENV} --disabled-password --gecos "" ${DOCKER_USERNAME_ENV}

# Install and update package
RUN APT_INSTALL="apt-get install -qq --no-install-recommends" && \
    apt-get update --fix-missing -qq && apt-get upgrade -qq && \
    # ==================================================================
    # tools
    # ------------------------------------------------------------------
        DEBIAN_FRONTEND=noninteractive $APT_INSTALL \
            locales \
            apt-utils \
            #software-properties-common \
            && \
        DEBIAN_FRONTEND=noninteractive $APT_INSTALL \
            ca-certificates \
            git mercurial subversion \
            nano sed \
            libssl-dev \
            supervisor supervisor-doc \
            cron \
            curl wget \
            grep dpkg \
            inetutils-ping \
            tmux man htop mc \
            tar gzip bzip2 zip unzip \
            libglib2.0-0 \
            && \
        localedef -i ${LOCALE_LANGUAGE_ENV} -c -f ${LOCALE_CHARSET_ENV} -A /usr/share/locale/locale.alias ${LOCALE_LANGUAGE_ENV}.${LOCALE_CHARSET_ENV} \
            && \
    # ==================================================================
    # config & cleanup
    # ------------------------------------------------------------------
        ldconfig && \
        apt-get clean -qq && \
        apt-get autoremove -qq && \
        rm -rf /var/lib/apt/lists/* /tmp/* ~/*

ENV LANG=${LOCALE_LANGUAGE_ENV}.${LOCALE_CHARSET_ENV} LC_ALL=${LOCALE_LANGUAGE_ENV}.${LOCALE_CHARSET_ENV}

# Set zoneinfo
RUN ln -snf /usr/share/zoneinfo/${TZ_ENV} /etc/localtime && echo ${TZ_ENV} > /etc/timezone

WORKDIR ${DOCKER_WORKDIR_ENV}

