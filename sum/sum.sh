#!/bin/sh

param1=$1
param2=$2

regexp="^[+-]?[0-9]+([.][0-9]+)?$"
error=0

for i in 1 2
do
    variablename="param${i}"
    if ! [[ ${!variablename} =~ $regexp ]] ; then
       echo "Ошибка: Параметр ${i} (${!variablename}) не является числом"
       error=1
    fi
done

if [[ $error -eq 1 ]] ; then
    exit
fi

sum=$(echo "${param1} + ${param2}"|bc)
echo "Сумма чисел введённых чисел ${param1} + ${param2} = ${sum}"