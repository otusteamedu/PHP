#!/bin/sh
set -e

if [[ ! -d /app/vendor/spiral ]]
    then
        composer -n install --no-dev
fi

/home/app/bin/rr serve -c /usr/local/etc/roadrunner/rr.yml $@
