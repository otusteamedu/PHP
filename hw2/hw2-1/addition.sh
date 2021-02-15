#!/bin/bash
regEx="^[+-]?[0-9]+([.][0-9]+)?$" # Регулярное выражение для проверки типа входных данных
echo "Скрипт для сложения двух чисел."

echo "Введите первое число:"
read firstNumber

echo "Введите второе число:"
read secondNumber

if ! [[ $firstNumber =~ $regEx ]] || ! [[ $secondNumber =~ $regEx ]]
then
echo "Введенные значения не являются числами"
exit 1
fi

awk "BEGIN { print \"Result:\", $firstNumber + $secondNumber; exit }"
exit 0