#!/usr/bin/env bash

set -eu

: "${DOCKER_USERNAME_ENV:=web}"
: "${HOST_USER_ID:=1000}"
: "${HOST_GROUP_ID:=1000}"

echo "Fixing permissions."
UNUSED_USER_ID=21338
UNUSED_GROUP_ID=21337

# Setting Group Permissions
DOCKER_GROUP_CURRENT_ID=`id -g ${DOCKER_USERNAME_ENV}`

if [[ ${DOCKER_GROUP_CURRENT_ID} -ne ${HOST_GROUP_ID} ]]; then
  echo "Check if group with ID ${HOST_GROUP_ID} already exists"
  DOCKER_GROUP_OLD=`getent group ${HOST_GROUP_ID} | cut -d: -f1`

  if [[ -n "${DOCKER_GROUP_OLD}" ]]; then
    echo "Changing the ID of ${DOCKER_GROUP_OLD} group to 21337"
    groupmod -o -g ${UNUSED_GROUP_ID} ${DOCKER_GROUP_OLD}
  fi

  echo "Changing the ID of ${DOCKER_USERNAME_ENV} group to ${HOST_GROUP_ID}"
  groupmod -o -g ${HOST_GROUP_ID} ${DOCKER_USERNAME_ENV} || true
  echo "Finished"
fi

# Setting User Permissions
DOCKER_USER_CURRENT_ID=`id -u ${DOCKER_USERNAME_ENV}`

if [[ ${DOCKER_USER_CURRENT_ID} -ne ${HOST_USER_ID} ]]; then
  echo "Check if user with ID ${HOST_USER_ID} already exists"
  DOCKER_USER_OLD=`getent passwd ${HOST_USER_ID} | cut -d: -f1`

  if [[ -n "${DOCKER_USER_OLD}" ]]; then
    echo "Changing the ID of ${DOCKER_USER_OLD} to 21337"
    usermod -o -u ${UNUSED_USER_ID} ${DOCKER_USER_OLD}
  fi

  echo "Changing the ID of ${DOCKER_USERNAME_ENV} user to ${HOST_USER_ID}"
  usermod -o -u ${HOST_USER_ID} ${DOCKER_USERNAME_ENV} || true
  echo "Finished"
fi

# add DOCKER_INTERNAL_HOST for mysql connect
DOCKER_INTERNAL_HOST="host.docker.internal"
if ! grep ${DOCKER_INTERNAL_HOST} /etc/hosts > /dev/null ; then
    DOCKER_INTERNAL_IP=`/sbin/ip route | awk '/default/ { print $3 }' | awk '!seen[$0]++'`
    echo -e "${DOCKER_INTERNAL_IP}\t${DOCKER_INTERNAL_HOST}" >> /etc/hosts
    echo "Added ${DOCKER_INTERNAL_HOST} to hosts /etc/hosts"
fi

SUDO_WEB="sudo -u ${DOCKER_USERNAME_ENV}"

# composer install
${SUDO_WEB} composer --working-dir=/home/${DOCKER_USERNAME_ENV}/www/app.local/ install
${SUDO_WEB} composer --working-dir=/home/${DOCKER_USERNAME_ENV}/www/laravel.local/ install

# env
EnvAppFile="/home/${DOCKER_USERNAME_ENV}/www/app.local/.env"
if [[ ! -f "${EnvAppFile}" ]]; then
    ${SUDO_WEB} cp -n "${EnvAppFile}.example" "${EnvAppFile}"
fi

EnvLaravelFile="/home/${DOCKER_USERNAME_ENV}/www/laravel.local/.env"
if [[ ! -f "${EnvLaravelFile}" ]]; then
    ${SUDO_WEB} cp -n "${EnvLaravelFile}.example" "${EnvLaravelFile}"
    ${SUDO_WEB} php "/home/${DOCKER_USERNAME_ENV}/www/laravel.local/artisan" key:generate
fi

# start
exec "$@"
