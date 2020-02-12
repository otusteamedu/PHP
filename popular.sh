#!/bin/bash

# В качестве первого параметра получаем файл, в котором надо найти
# самый популярный город среди пользователей.

if ! [[ -f $1 ]]; then
  echo "error: File not exist - $1"
  exit 1
fi

awk -F"\t" 'FNR>1{ print $3 }' $1 | sort | uniq -c | sort -rnk1 | head -n 3 | awk '{ print $2 }'
