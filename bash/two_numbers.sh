#!/bin/bash

re='^-?[0-9]+(\.[0-9]+)?$'

firstNumber=$1
secondNumber=$2

while ! [[ $firstNumber =~ $re ]] || ! [[ $secondNumber =~ $re ]]
do
echo 'Пожалуйста, введите 2 числа, через пробел'
read firstNumber secondNumber;
done

echo "$secondNumber + $firstNumber" | bc 

exit 0