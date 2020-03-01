#!/bin/bash

x=$1
y=$2

regexp="^(-)?[0-9]+(\.)?[0-9]*$"

if [[ $x =~ $regexp ]];
  then x=$x
  else x=0 ; echo "В первом параметре введено не числовое значение"
fi

if [[ $y =~ $regexp ]];
 then y=$y
 else y=0 ; echo "В втором параметре введено не числовое значение"
fi

echo -n "Сумма чисел: " && bc <<< "$x+$y"