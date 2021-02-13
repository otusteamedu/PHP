#!/bin/bash

function isNumber() {
    [[ $1 =~ ^[-]?[0-9]+([.{1}][0-9]+)?$ ]]
}

function showErrorIsNotNumber() {
  echo "$1 значение $2 не является числом!"
}

read -p 'Введите первое число: ' number1
read -p 'Введите второе число: ' number2

if ! isNumber $number1
then
  showErrorIsNotNumber 'Первое' $number1
  exit 1
elif ! isNumber $number2
then
  showErrorIsNotNumber 'Второе' $number2
  exit 1
fi

# Т.к. bash не поддерживает вычисления с числами с плавающей точкой.
# Поэтому для вычисления можно использовать awk или bc.
sum=$(echo "$number1 $number2" | awk '{sum += $1 + $2} END { print sum }')
# Вариант использования bc. Например, sum=$(echo "$number1 + $number2" | bc)

echo "Сумма чисел $number1 и $number2 равна $sum"

exit 0
