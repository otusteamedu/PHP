#!/bin/bash

if [[ ! -f $1 ]]
    then
        echo "ОШИБКА: Указанный файл не найден"
        exit 1
fi

awk 'length && $0!="id user city phone" {print $3}' $1 | sort | uniq -c | sort -nr | head -n 3 | awk '{print $2}'
