#!/bin/bash

# Проверяем количество аргументов
if [ $# -ne 2 ]
then
    echo "Prints a sum of two numbers"
    echo "Usage: sum.sh NUM1 NUM2"
    echo "    NUM1 and NUM2 are numeric values"
    exit 1
fi

# Функция проверющая валидность аргумента (можно вводить только целые числа)
test_argument() {
    if [[ ! $1 =~ ^[0-9]+$ ]] # Вариант для использования интерпретатора bash
    then
        echo "$1 is not a numeric value"
        exit 1
    fi
}

# Проверяем что аргументы валидны
test_argument $1
test_argument $2

# Выводим сумму
echo $(($1+$2))
