#!/bin/bash

check=`echo "$1" | grep -E ^\-?[0-9]*[.]?[0-9]+$`
check2=`echo "$2" | grep -E ^\-?[0-9]*[.]?[0-9]+$`

if [ "$check" != '' ] && [ "$check2" != '' ]; then
  echo "$1" + "$2" | bc
else
  echo "Введите правильные аргументы! Только числа."
fi
