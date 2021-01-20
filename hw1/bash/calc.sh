#!/bin/bash

reg="^-?[0-9]+[,]?[0-9]+?$"

if ! [[ "$1" =~ $reg && "$2" =~ $reg ]]; then
    echo "Неверный тип данных"
    exit 1
fi

echo "$1 $2" | awk '{ print $1+$2}'
exit 0
