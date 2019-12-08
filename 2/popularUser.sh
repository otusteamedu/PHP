#!/bin/bash

file=$1

if [[ -z "$file" ]]; then
    echo "Не передано имя файла"
    exit 1
fi

if [[ ! -f "$file" || ! -s "$file" ]]; then
    echo "Файл пуст или несуществует"
    exit 1
fi



exit 0
