#!/bin/bash
if [ "$#" -ne 2 ]; then
    echo "Скрипт принимает только 2 параметра"
    exit 1
fi
expr="^-?[0-9]+([.][0-9]+)?$"
if ! [[ $1 =~ $expr && $2 =~ $expr ]] ; then 
	echo "Оба параметра должны быть числами"
	exit 1
fi
echo "$1 + $2" |bc
exit 0