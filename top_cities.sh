#!/bin/bash
filename=$1
if [[ $filename == "" ]]; then
  echo 'Укажите название файла "./top_cities.sh cities.txt"'
  exit 1
fi

awk 'BEGIN {FS=" "} NR>1 {print $3}' $filename | sort | uniq -c | sed 's/^\s*//' | sort -rn | head -n3 | awk 'BEGIN {FS=" "} {print $2}'

exit 0