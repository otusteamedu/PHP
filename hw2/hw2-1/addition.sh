#!/bin/bash
regEx="^[+-]?[0-9]+([.][0-9]+)?$" # Регулярное выражение для проверки типа входных данных
echo "Скрипт для сложения двух чисел."

echo "Введите первое число:"
read firstNumber

echo "Введите второе число:"
read secondNumber

if ! [[ $firstNumber =~ $regEx ]] || ! [[ $secondNumber =~ $regEx ]]
then
echo "Введенные значения не являются целыми числами"
exit 1
fi

sum=$(($firstNumber + $secondNumber))
echo "Сумма: $sum"
exit 0