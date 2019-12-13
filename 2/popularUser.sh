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

data=$( tail -n+2 "$file" | sort -t " " -i -k2 -k3 -k4 -k1n | uniq --skip-fields=1 | awk -f ./script.awk | sort -t " " -k1nr | head -n3 | awk -F " " '{print $2}' )
echo "$data"

exit 0
