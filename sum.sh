#!/bin/bash

#проверяет корректность введенных чисел (должны быть вещественные и отрицательные)
function validateNumber 
{
  local realNumber='^[+-]?[0-9]+([.][0-9]+)?$'
  if ! [[ $1 =~ $realNumber ]] ; then
      echo "false"
      return 0;
  fi
  echo "true";
}

echo 'Введите 2 числа, для вычисления суммы!'
echo 'Введите число 1:'
read -r number1
validateResult=$(validateNumber "$number1");

while [ "$validateResult" == "false" ]; do
  echo 'Введено неверное число 1 (должно быть вещественное число):'
  echo 'Введите число 1:'
  read -r number1;
  validateResult=$(validateNumber "$number1");
done

echo 'Введите число 2:'
read -r number2
validateResult=$(validateNumber "$number2");

while [ "$validateResult" == "false" ]; do
  echo 'Введено неверное число 2 (должно быть вещественное число):'
  echo 'Введите число 2:'
  read -r number2;
  validateResult=$(validateNumber "$number2");
done

sum=$( awk "BEGIN { print($number1 + $number2) }" );
echo "Сумма числа $number1 и числа $number2 равна $sum"