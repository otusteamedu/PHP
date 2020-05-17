# !/bin/bash
re='^-?[0-9]+$'
echo "Введите первое число:"
read a
if ! (echo $a | grep -Eq $re) ; then
    echo "Ошибка: Вы ввели не число."; exit 1
fi

echo "Введите второе число:"
read b
if ! (echo $a | grep -Eq $re) ; then
    echo "Ошибка: Вы ввели не число."; exit 1
fi

echo "Сумма чисел $a и $b равна $(($a+$b))"