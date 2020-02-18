#!/bin/bash

regexnumber='^-?[0-9]+$'

if [[ $1 =~ $regexnumber ]] && [[ $2 =~ $regexnumber ]]
then
  echo $(($1+$2))
else
  echo "Ошибка ввода. Допустимы только цифры."
fi