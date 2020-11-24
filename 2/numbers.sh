#!/bin/bash

check=`echo "$1$2" | grep -E ^\-?[0-9]*[.]?[0-9]+$`

if [ "$check" != '' ]; then
  echo $1 $2 | awk '{print $1 + $2}'
else
  echo "Введите правильные аргументы! Только числа."
fi
