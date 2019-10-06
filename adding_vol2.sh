#!/bin/bash
echo "Сложение двух чисел"
echo "Введите число A:"
read a
echo "Введите число B:"
read b
echo | awk -v x=$a -v y=$b -f sum.awk
exit 0
