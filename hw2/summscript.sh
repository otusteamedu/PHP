#!/bin/bash

# регулярка с дробными числами возможно отрицательными
reg='^[-]?[0-9]+([.][0-9]+)?$'

echo "Введите первое число:"
read n1
if ! [[ $n1 =~ $reg ]]; then
  echo "Число не корректно"
  exit 1
fi

echo "Введите второе число:"
read n2
if ! [[ $n2 =~ $reg ]]; then
  echo "Число не корректно"
  exit 1
fi
echo "Результат:"
echo $(awk "BEGIN {print $n1+$n2; exit;}")
