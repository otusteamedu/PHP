#!/bin/bash
echo "Введите 2 числа через пробел:"
read one two

if [[ $one =~ ^[0-9.]+$ && $two =~ ^[0-9.]+$ ]]
	then
		echo "Ответ:" $(($one + $two))
	else
		echo "Ошибка! только цифры!"
fi