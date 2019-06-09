#!/bin/bash
echo "Введите число a: "
read a
echo "Введите число b: "
read b

digital='^(-+)?[0-9]+([.][0-9]+)?$'

if [[ $a =~ $digital ]] && [[ $b =~ $digital ]]
then
echo "Сумма введенных Вами чисел:"
echo $a + $b | bc
else
echo "Вы ввели некорректные данные, попробуйте запустить скрипт еще раз"
exit 0
fi