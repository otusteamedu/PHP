#!/usr/bin/env bash

if [[ $# != 2 ]]; then
    >&2 echo "Необходимо ввести 2 числа"
    exit
fi

regexp='^-?[0-9]+\.?[0-9]*$'

for arg
do
    if [[ ! ${arg} =~ ${regexp} ]]; then
        >&2 echo "Аргумент ${arg} не является числом"
        exit
    fi
done

echo $1 + $2 | bc