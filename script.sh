#!/usr/bin/env bash

if [[ $# < 2 ]]; then
    echo "Script expects 2 arguments, $# given"
    exit
fi

if ! [[ $1 =~ ^-?[0-9]+([.][0-9]+)?$ ]] || ! [[ $2 =~ ^-?[0-9]+([.][0-9]+)?$ ]]; then
    echo "One of the arguments is not a number"
    exit;
fi

echo $1 + $2 | bc
