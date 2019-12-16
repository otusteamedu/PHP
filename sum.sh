#!/bin/bash

if (( $# != 2 )); then
  echo "Не корректное количество параметров. Должно быть два числовых патаметра."  >&2
  exit 1
fi

var1=$1
var2=$2

pattern='^0{1}$|^[-]?[0]{1}[.]{1}[0-9]*$|^[-]?[1-9]{1}[0-9]*[.]?[0-9]*$'

error=0
for i in 1 2; do
  var="var${i}"
  if ! [[ "${!var}" =~ $pattern ]]
  then
    echo "Параметр №$i (${!var}) - не корректное число." >&2
    error=1
  fi
done

if [[ $error -eq 1 ]]
then
  echo "Исправьте ошибки и повторите попытку!"
  exit 1
fi

sum=$(echo $var1 + $var2 | bc)

echo "Сумма чисел $var1 и $var2 равна $sum"