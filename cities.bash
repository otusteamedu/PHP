#!/usr/bin/env bash

if [[ $# != 1 ]]; then
    >&2 echo "Необходимо передать название файла"
    exit
fi

if [[ ! -f ${1} ]]; then
    >&2 echo "Файл ${1} не найден"
    exit
fi

tail -n+2 ${1} \
| awk '{cities[$3] += $4}END {for (city in cities) {print city " - " cities[city]}}' \
| sort -rnk3 \
| head -n 3
