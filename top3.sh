#!/bin/bash

if [[ $1 == "" ]]
then
    echo "Введите имя файла"
    exit 1
fi
awk '($3 != "") && (NR > 1) { print $3 }' $1 | sort | uniq -c | sort -k1 -r | head -n3 | awk '{ print $2 }'
exit 0