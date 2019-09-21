#!/usr/bin/bash
echo -n "Введите значение A:"
read a
echo -n "Введите значение B:"
read b

numericRegexp='^[-]?[0-9]+([.][0-9]+)?$'

if [[ $a =~ $numericRegexp  && $b =~ $numericRegexp ]]
then
  echo -n "A+B="
  echo "$a+$b" |bc
  else
    echo "Вы ввели неправильные значения, введите вещественые числа"
    fi