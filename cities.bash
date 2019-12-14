#!/usr/bin/env bash

if [[ $# != 1 ]]; then
    >&2 echo "Необходимо передать название файла"
    exit
fi

if [[ ! -f ${1} ]]; then
    >&2 echo "Файл ${1} не найден"
    exit
fi

tail -n+2 ${1} | awk -f awk_script | sort -r -k2 | head -n 3