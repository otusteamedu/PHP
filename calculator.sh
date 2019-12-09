#!/bin/bash
number1=$1
number2=$2

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $number1 =~ $re && $number2 =~ $re ]]
  then echo "error: Not a number" >&2; exit 1
fi
echo "$number1+$number2" |bc
