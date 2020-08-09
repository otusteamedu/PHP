#!/bin/bash

re='^-?[0-9]+(\.[0-9]+)?$'

firstNumber=$1
secondNumber=$2

if ! [[ $firstNumber =~ $re ]] || ! [[ $secondNumber =~ $re ]]
then
echo 'Первый или второй аргумент не число'
exit 1
fi

echo "$secondNumber + $firstNumber" | bc 

exit 0