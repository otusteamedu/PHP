#!/bin/bash
echo ""
echo "СЛОЖЕНИЕ ДВУХ ЧИСЕЛ"
echo ""

re='^-?[0-9]+\.?[0-9]*$'
inputMessages=("Введите первое слагаемое: " "Введите второе слагаемое: ")

for (( i = 0; i < ${#inputMessages[*]}; i++ ))
do
    read -p "${inputMessages[$i]}" value
    
    if [[ ! $value =~ $re ]]
    then
        echo "Введённое не является числом"
        exit 1
    fi
    
    if [ $i -eq 0 ]
    then
        expression="$value"
    else
        expression="$expression+$value"
    fi
done

echo ""
echo "$expression" | awk -F'+' '{sum = $1 + $2} {print $1 " + " $2 " = " sum}'
