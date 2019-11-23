#!/usr/bin/env bash
if [[ "$#" -lt 2 ]]
then
	echo 'Введите два числа разделенные пробелом для подсчета их суммы'
	echo "Вы ввели $*"
	exit 1
fi
num1=$1
num2=$2

if ! [[ $num1 =~ ^[+-]?([0-9]*[.])?[0-9]+$ && $num2 =~ ^[+-]?([0-9]*[.])?[0-9]+$ ]]
then
    echo 'Введите числа'
    echo "Вы ввели $*"
    exit 1
fi

awkCalcCommands='
BEGIN {
print num1 + num2
}
';

awk -v num1=$num1 -v num2=$num2 "$awkCalcCommands"

exit 0