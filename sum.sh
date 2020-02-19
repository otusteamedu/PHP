#!/bin/bash

regexnumber='^[0-9]*[.,]?[0-9]+$'

if [[ $1 =~ $regexnumber ]] && [[ $2 =~ $regexnumber ]]
then
  echo $(echo "$1 + $2" | bc )
else
  echo "Ошибка ввода. Допустимы только цифры."
fi