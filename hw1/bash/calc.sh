#!/usr/bin/bash

reg="^-?[0-9]+[.]?[0-9]+?$"
number1=$1
number2=$2

if ! [[ "$number1" =~ $reg && "$number2" =~ $reg ]]; then
    echo "Неверный тип данных"
    exit 1
fi

result=$(echo "$number1+$number2" | bc -l)
echo "$result"

exit 0
