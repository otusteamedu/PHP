#!/usr/bin/env bash

NUMBER_REGEX="^[+-]?(\d*\.)?\d+$"

if [ "$#" -ne 2 ]; then
    echo 2 arguments required >&2
elif ! [[ $1 =~ $NUMBER_REGEX ]]; then
    echo arguments 1 is not a number >&2
elif ! [[ $2 =~ $NUMBER_REGEX ]]; then
    echo arguments 2 is not a number >&2
else
    echo $1 + $2 | bc
    exit 0
fi
exit 1