#!/bin/bash
read -p "Type first num :" number

if [[ ! $number =~ ^[+-]?[0-9]*$ ]] && [[ ! $number =~ ^[+-]?[0-9]+\.?[0-9]*$ ]];then
echo "Type is not a number"
exit
fi

read -p "Type second num :" number2

if [[ ! $number2 =~ ^[+-]?[0-9]*$ ]] && [[ ! $number2 =~ ^[+-]?[0-9]+\.?[0-9]*$ ]];then
echo "Type is not a number"
exit
fi

echo -n "sum "
echo "$number + $number2" | bc