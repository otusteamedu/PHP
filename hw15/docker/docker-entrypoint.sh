#!/bin/sh
set -eux

composer install --prefer-dist --no-progress --no-suggest --no-interaction

exec docker-php-entrypoint "$@"