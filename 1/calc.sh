#!/bin/bash

value_1=$1
value_2=$2
regexpNumber="^-?[0-9]+(\.[0-9]+)*$"

if [[ -z "$value_1" || -z "$value_2" ]]; then
  echo "Не переданы необходимые параметры"
  exit 1
fi

if [[ ! "$(echo $value_1 | grep -E $regexpNumber)" ]]; then
  echo "Первый параметр не число"
  exit 1
fi

if [[ ! "$(echo $value_2 | grep -E $regexpNumber)" ]]; then
  echo "Второй параметр не число"
  exit 1
fi

sum=$(echo "$value_1 + $value_2" | bc)
echo $sum

exit 0
