#!/usr/bin/env bash

function isNumeric {
    if ! [[ $1 =~ ^[-]?[0-9]+([.][0-9]+)?$ ]]
    then
        echo "Input value: '$1' is invalid"
        exit 1
    fi
}

isNumeric $1
isNumeric $2

echo $1*$2 | bc
exit 0
