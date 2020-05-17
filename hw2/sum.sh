#!/bin/bash
first=$1
second=$2
verifyDig='^[+-]?[0-9]+([.][0-9]+)?+$'
red='\033[0;31m'
nocolor="\033[0m"
error="${red}error:${nocolor}"

if ! [ "$#" -eq "2" ] ;
then
 echo -e "$error недостаточно параметров" >&2; exit 1
fi

if ! [[ $first =~ $verifyDig ]];
then
 echo -e "$error первый папраметр $first не число" >&2; exit 1
fi

if ! [[ $second =~ $verifyDig ]];
then
 echo -e "$error второй параметр $second не число" >&2; exit 1
fi

echo $first $second | awk '{print "Сумма " $1 " и " $2 " = "  $1 + $2}'
