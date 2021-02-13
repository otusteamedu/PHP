#!/bin/bash
param1=$1
param2=$2
 
reg_num='/^(\-?0*[1-9][0-9]*(\.[0-9]+)?|\-?0+\.[0-9]*[1-9][0-9]*)$/{print $0}'

echo "Параметр1=$param1, Параметр2=$param2"

while [[ $(echo "$param1" | awk "$reg_num") == "" ]]
do
echo "Требуется чтобы первый параметр был числом!!!"
read -p "Введите число->" param1
done

while [[ $(echo "$param2" | awk "$reg_num") == "" ]]
do
echo "Требуется чтобы второй параметр был числом!!!"
read -p "Введите число->" param2
done

sum=$(echo "$param1 + $param2" | bc)
echo "Слагаемое1 = $param1, Слагаемое2 = $param2 и их сумма равна $sum"

exit 0
