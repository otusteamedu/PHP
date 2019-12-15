#!/bin/bash
number1=$1
number2=$2

re='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ -n "$number1" && -n "$number2" ]]
then
	echo "Error: No parameters found" >&2; exit 1
fi

if ! [[ $number1 =~ $re && $number2 =~ $re ]]
then 
	echo "Error: parameters not number" >&2; exit 1
fi

result=$(echo "$number1+$number2" | bc -l)
echo "Cумма чисел $number1 и $number2 равно $result"