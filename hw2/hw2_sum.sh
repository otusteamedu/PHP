#!/bin/bash
isnumberregexp='^-?[0-9]+$'
if [[ $1 =~ $isnumberregexp ]] && [[ $2 =~ $isnumberregexp ]];
then
    echo $(($1 + $2))
else
    echo "Ошибка! Аргументы должны быть целыми числами"
fi
