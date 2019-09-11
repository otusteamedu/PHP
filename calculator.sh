#!/usr/bin/env bash

num1=$1
num2=$2
reg='^[0-9]+$'

if [[ $num1 =~ $reg && $num2 =~ $reg ]]
then
sum=$(($num1+$num2))
echo "Сумма введенных вами чисел - $sum"

else

echo "Вы ввели не целые положительные числа, а что-то другое"
exit 1

fi