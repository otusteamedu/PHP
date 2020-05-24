#!/bin/bash

reg="^-?[0-9]+$"

if [[ $1 =~ $reg ]] && [[ $2 =~ $reg ]]; then
    echo $(($1 + $2)) 
else
    echo "Введите число"
fi
