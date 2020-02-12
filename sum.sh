#!/bin/bash

# Принимает любое количество чисел в виде параметров и выводит их сумму в стандартный вывод.
# Может принимать дробные числа.

# Числа вида 10, 12.5, -1
pattern='^[-+]?[0-9]+([.][0-9]+)?$'
sum=0

for num in "$@"
do
  # Проверка параметра на валидность
  if ! [[ $num =~ $pattern ]] ; then
    echo "error: Not a number - $num"
    exit 1
  fi

  sum=$(bc<<<"$sum + $num")
done

echo "Total: $sum"
