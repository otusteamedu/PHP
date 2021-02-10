#!/bin/bash

function checkNumber {
	re='^[+-]?[0-9]+([.][0-9]+)?$'
	if ! [[ $1 =~ $re ]] ; then
   		echo "0";
   		exit 1;
	fi
	echo "1"
}

sum=null
until [ "$sum" != null ]
do
echo 'Введите первое число'
read first
echo 'Введите второе число'
read second
isFirtsValid=$( checkNumber $first)
isSecondValid=$( checkNumber $second)

if [[ isFirtsValid -eq 1 && isSecondValid -eq 1 ]]; then
	let "sum = first + second"
else
	echo 'Ошибка: введены некорректные символы'.
fi

done

echo "Сумма: $sum"
exit 0 