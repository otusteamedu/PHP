#!/usr/bin/env bash

if [[ $# != 1 ]]; then
    >&2 echo "Необходимо передать название файла"
    exit
fi

if [[ ! -f ${1} ]]; then
    >&2 echo "Файл ${1} не найден"
    exit
fi

tail -n+2 $1 | awk '{print $3}' | sort | uniq -c | sort -k1nr | head -n3
