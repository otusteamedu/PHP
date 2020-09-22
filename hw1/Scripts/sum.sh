#!/bin/bash

re=^-?[0-9]+[.]?[0-9]*$

if [ -n "$1" ]; then

  a=$1
  b=$2

 while ! [[ "${a}" =~ ${re} ]]
 do
    echo "ОШИБКА: '${a}' Параметр должен быть числом"
    read -p "Первый параметр: " a
 done

 while ! [[ "${b}" =~ ${re} ]]
 do
    echo "ОШИБКА: '${b}' Параметр должен быть числом"
    read -p "Второй параметр: " b
 done


  echo -n "$a + $b = "
  echo "$a+$b" | bc

else

  echo "Укажите два параметра"

fi
