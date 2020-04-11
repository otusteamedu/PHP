#!/bin/bash
isdigit='^[-]?[0-9]+(.[0-9]+)?$'
if [ $# -ne 2 ]; then
    echo "Я могу складывать только 2 числа"
    exit 1
fi
if ! [[ $1 =~ $isdigit ]] || ! [[ $2 =~ $isdigit ]]; then
    echo "Я могу складывать только числа"
    exit 2
fi
echo $1 + $2 | bc
exit 0