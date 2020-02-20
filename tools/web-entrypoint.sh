#!/usr/bin/env bash

set -euo pipefail

: "${DOCKER_USERNAME_ENV:=web}"
: "${UNPRIVILEGUE_PORT_MAPPING_80_ENV:=8080}"
: "${UNPRIVILEGUE_PORT_MAPPING_443_ENV:=8443}"
: "${UNIX_PHP_SOCK:=unix:/socks/php7.3-fpm-1.sock}"

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
    sed -i -e "s@%UNIX_PHP_SOCK%@${UNIX_PHP_SOCK}@g" "$filePath"
done <<< "$(find /etc/nginx/sites-available -type f -name '*.conf' && find /etc/nginx/sites-enabled -type f -name '*.conf')"

# start
exec nginx -g 'daemon off;'
