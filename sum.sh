#!/bin/bash
#https://github.com/fubata
# Скрипт можно вызывать с аргументами и без аргументов

summandOne=$1
summandTwo=$2

function isInt() {
  regexp='^[0-9]+([.][0-9]+)?$'
    until [[ $summandOne =~ $regexp ]] &&  [[ $summandTwo =~ $regexp ]]
    do
      enterNumber
    done
    result
}

function enterNumber {
  echo -e "Для операции сложения нужно два числа. \nУкажите первое число"
  read summandOne
  echo "Укажите втрое слагаемое: "
  read summandTwo
  isInt
}

function result {
sum=$(bc <<< "$summandOne + $summandTwo")
echo "$summandOne + $summandTwo = $sum"
exit
}


if [[ $# -ne 2 ]]
 then
  enterNumber
  isInt
  result
    else
      isInt
      result
fi