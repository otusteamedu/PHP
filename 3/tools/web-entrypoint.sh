#!/usr/bin/env bash

set -eu
#o pipefail

: "${HOST_USER_ID:=1000}"
: "${HOST_GROUP_ID:=1000}"
: "${DOCKER_USERNAME_ENV:=web}"
: "${DOCKER_WORKDIR_ENV:=/home/web}"
: "${BACKEND_HOST_PORT:=9000}"
: "${UNPRIVILEGUE_PORT_MAPPING_80_ENV:=8080}"
: "${UNPRIVILEGUE_PORT_MAPPING_443_ENV:=8443}"

# Copy nginx config
if [[ -d /etc/nginx/sites-available.ro ]] ; then
    rm -rf /etc/nginx/sites-available/*.conf
    cp -r /etc/nginx/sites-available.ro/*.conf /etc/nginx/sites-available
fi
if [[ -d /etc/nginx/sites-enabled.ro ]] ; then
    rm -rf /etc/nginx/sites-enabled/*.conf
    cp -r /etc/nginx/sites-enabled.ro/*.conf /etc/nginx/sites-enabled
fi

# Change placeholders in nginx config
while IFS= read -r filePath ; do
    [[ -n "$filePath" ]] || continue
    sed -i -e "s@%USERNAME%@${DOCKER_USERNAME_ENV}@g" "$filePath"
    sed -i -e "s@%MAPPING_PORT_80%@${UNPRIVILEGUE_PORT_MAPPING_80_ENV}@g" "$filePath"
    sed -i -e "s@%MAPPING_PORT_443%@${UNPRIVILEGUE_PORT_MAPPING_443_ENV}@g" "$filePath"
done <<< "$(find /etc/nginx/sites-available -type f -name '*.conf' && find /etc/nginx/sites-enabled -type f -name '*.conf')"


echo "Setting permissions for the docker container..."

UNUSED_USER_ID=21338
UNUSED_GROUP_ID=21337

# Setting Group Permissions
DOCKER_GROUP_CURRENT_ID=`id -g ${DOCKER_USERNAME_ENV}`
if [[ ${DOCKER_GROUP_CURRENT_ID} -ne ${HOST_GROUP_ID} ]]; then
    echo "Check if group with ID ${HOST_GROUP_ID} already exists"
    DOCKER_GROUP_OLD=`getent group ${HOST_GROUP_ID} | cut -d: -f1`

    if [[ -n ${DOCKER_GROUP_OLD} ]]; then
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
    echo "Check if user with ID $HOST_USER_ID already exists"
    DOCKER_USER_OLD=`getent passwd ${HOST_USER_ID} | cut -d: -f1`

    if [[ -n ${DOCKER_USER_OLD} ]]; then
        echo "Changing the ID of ${DOCKER_USER_OLD} to 21337"
        usermod -o -u ${UNUSED_USER_ID} ${DOCKER_USER_OLD}
    fi

    echo "Changing the ID of ${DOCKER_USERNAME_ENV} user to ${HOST_USER_ID}"
    usermod -o -u ${HOST_USER_ID} ${DOCKER_USERNAME_ENV} || true
    echo "Finished"
fi

chown -R ${DOCKER_USERNAME_ENV}:${DOCKER_USERNAME_ENV} ${DOCKER_WORKDIR_ENV} || true
echo "Done."

# start
exec "$@"
