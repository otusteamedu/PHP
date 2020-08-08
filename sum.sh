#!/bin/bash

#проверяет корректность введенных чисел (должны быть вещественные и отрицательные)
function validateNumber 
{
  local realNumber='^[+-]?[0-9]+([.][0-9]+)?$'
  local error=0;

  if ! [[ $1 =~ $realNumber ]] ; then
      echo "Ошибка! Введенный параметр $1 не является числом!"
      error+=1;
  fi

  if ! [[ $2 =~ $realNumber ]] ; then
      echo "Ошибка! Введенный параметр $2 не является числом!"
      error+=1;
  fi

  if [[ $error -gt 0 ]] ; then
    exit 1
  fi
}


echo 'Введите 2 числа, для вычисления суммы!'
echo 'Число 1:'
read -r number1
echo 'Число 2:'
read -r number2

validateNumber "$number1" "$number2"

sum=$( echo "$number1+$number2" | bc -l);

echo "Сумма числа $number1 и числа $number2 равна $sum"
