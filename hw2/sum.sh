#!/bin/bash

isNumber='^[+-]?[0-9]+([.][0-9]+)?$'

if [[ $1 =~ $isNumber ]] && [[ $2 =~ $isNumber ]]
then
    sum=$(($1 + $2))
    echo "Result: $1 + $2 = $sum."

else
    echo "Error: Arguments must be numbers" >&2
    exit 1
fi
