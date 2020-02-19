#!/bin/bash

if [[ $1 == "" ]]
then
    echo "Введите имя файла"
    exit 1
fi
awk '($3 != "") && (NR > 1)' $1 | awk '++array[$3] { print array[$3] " " $3  }' | sort -r | awk '!array[$2]++' | head -n3 | awk '{ print $2 }'
exit 0