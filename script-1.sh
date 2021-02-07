#!/bin/bash #указываем где у нас хранится bash-интерпретатор
re = "^-?[0-9]+$"
echo 'Введите первый аргумент'
read param1
echo 'Введите второй аргумент'
read param2

if ! (("$param1" | grep -E -q "$re")) || ! (("$param2" | grep -E -q "$re"));
 then
    echo "Можно складывать только числа!"
    exit 1
else
    let "result = $param1 + $param2 "
    echo "Сумма равна $result"
fi

