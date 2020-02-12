#!/bin/bash

# ввод чисел через командную строку

echo "введите x"
read x
echo "введите y"
read y

if [[ $x != ?([+-])*([0-9])?(.*([0-9])) ]]; then echo "$x - не число" && exit; fi;
if [[ $y != ?([+-])*([0-9])?(.*([0-9])) ]]; then echo "$y - не число" && exit; fi;

awk "BEGIN {print \"сумма: $x + $y = \" ($x+$y)}"