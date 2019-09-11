#!/bin/bash

re='^[-]?[0-9]+\.?[0-9]*$'

if [[ ! $# -eq 2 ]]; then
    echo "error: Bad arguments count"
    exit 1
elif [[ ! $1 =~ $re ]] || [[ ! $2 =~ $re ]]; then
    echo "error: Bad argument(s). Not a number"
    exit 1
else
    echo $1 + $2 |bc
fi