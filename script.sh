#!/bin/bash

# проверка на количество переменных
if [ "$#" -ne 2 ]; then
    echo "Обязательное число параметров - 2!"
    exit 0;
fi

#присвоение значений
num1=$1
num2=$2

#валидация
if [[  $num1 =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]; then
	echo "$num1 -  валидно"
else
	echo "$num1 - не валидно"
	tput setaf 1; echo "скрипт завершен!"
	tput sgr0;
	exit 0;
fi

if [[  $num2 =~ ^[-+]?[0-9]+\.?[0-9]*$ ]]; then
	echo "$num2 -  валидно"
else
	echo "$num2 - не валидно"
	tput setaf 1; echo "скрипт завершен!"
	tput sgr0;
	exit 0;
fi

#суммирование
sum=$(echo "$num1+$num2" | bc -l)

tput setaf 2; echo "$num1 + $num2 = $sum" 
tput sgr0;
exit 1;