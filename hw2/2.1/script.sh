#!/usr/bin/env bash
if [[ "$#" -lt 2 ]]
then
	echo 'Введите два целых числа разделенные пробелом для подсчета их суммы'
	echo "Вы ввели $*"
	exit 1
fi
num1=$1
num2=$2
sum=0
if [[ $num1 =~ ^[0-9]+$ && $num2 =~ ^[0-9]+$ ]]
then
    sum=$(($num1 + $num2))
else
    echo 'Введите целые числа'
    echo "Вы ввели $*"
    exit 1
fi

echo $sum
exit 0