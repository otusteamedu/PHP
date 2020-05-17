#!/bin/bash
if [[ $1 =~ ^[+-]?[0-9]+([.][0-9]+)?$  ]] && [[ $2 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]
then 
    echo $1 + $2 | bc
elif [ $# -ne 2 ]
then
    echo "No summa for You... You set too few parametrs!"  >&2
    exit 22
else
    echo "I need number, not word!"  >&2
    exit 11
fi

