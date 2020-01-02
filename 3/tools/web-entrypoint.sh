#!/usr/bin/env bash

set -euo pipefail

: "${HOST_USER_ID:=1000}"
: "${HOST_GROUP_ID:=1000}"
: "${DOCKER_USERNAME_ENV:=web}"
: "${DOCKER_WORKDIR_ENV:=/home/web}"
: "${BACKEND_HOST_PORT:=9000}"
: "${UNPRIVILEGUE_PORT_MAPPING_80_ENV:=8080}"
: "${UNPRIVILEGUE_PORT_MAPPING_443_ENV:=8443}"
: "${DIR_RUN_ENV:=}"

if [[ -d /etc/nginx/sites-available.ro ]] ; then
    rm -rf /etc/nginx/sites-available/*.conf
    cp -r /etc/nginx/sites-available.ro/*.conf /etc/nginx/sites-available
fi
if [[ -d /etc/nginx/sites-enabled.ro ]] ; then
    rm -rf /etc/nginx/sites-enabled/*.conf
    cp -r /etc/nginx/sites-enabled.ro/*.conf /etc/nginx/sites-enabled
fi

while IFS= read -r filePath ; do
    [[ -n "$filePath" ]] || continue
    sed -i -e "s@%RUN_DIR%@${DIR_RUN_ENV}@g" "$filePath"
    sed -i -e "s@%USERNAME%@${DOCKER_USERNAME_ENV}@g" "$filePath"
    sed -i -e "s@%MAPPING_PORT_80%@${UNPRIVILEGUE_PORT_MAPPING_80_ENV}@g" "$filePath"
    sed -i -e "s@%MAPPING_PORT_443%@${UNPRIVILEGUE_PORT_MAPPING_443_ENV}@g" "$filePath"
done <<< "$(find /etc/nginx/sites-available -type f -name '*.conf' && find /etc/nginx/sites-enabled -type f -name '*.conf')"

echo "Setting permissions for the docker container..."
/tools/permission_fix.sh || true
chown -R ${DOCKER_USERNAME_ENV}:${DOCKER_USERNAME_ENV} ${DOCKER_WORKDIR_ENV} || true
echo "Done."

exec "$@"
