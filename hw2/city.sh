#!/bin/bash

file=$1
red='\033[0;31m'
nocolor="\033[0m"
error="${red}error:${nocolor}"

if ! [ "$#" -eq "1" ] ;
then
 echo -e "$error недостаточно параметров" >&2; exit 1
fi

if [[ ! -f $file ]];
then
    echo -e "файл не найден!"
    exit 1
fi

cat $file | awk 'NR>1'{'print NF $3'} | sort | uniq -c -i | sort -nrk 1 | head -3

exit 0
