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

data=$( head -n-0 -q "$file" | tail -n+2 | sort -ik2 -k3 -k4 | uniq --skip-fields=1 )
echo "$data"

exit 0
