#!/bin/sh

set -e

host="$1"
shift
cmd="$@"

echo "Ожидание запуска RabbitMQ..."
while ! curl -s "$host:15672" >/dev/null; do sleep 1; done
echo "RabbitMQ запущен"

# shellcheck disable=SC2086
exec $cmd