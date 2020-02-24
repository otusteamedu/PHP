#!/bin/sh
set -eux

composer install --prefer-dist --no-progress --no-suggest --no-interaction
vendor/bin/phinx seed:run -s UserSeeder

exec docker-php-entrypoint "$@"