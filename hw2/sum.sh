#!/bin/bash

reg='^[-]?[0-9]+[.]?[0-9]*$'
if ! [[ $1 =~ $reg && $2 =~ $reg ]]; then
  echo "Ошибка! Могут быть введены только числа."
  exit 1
fi
result=$(bc <<< "$1 + $2")
echo "Результат:"
echo "$1 + $2 = $result"
