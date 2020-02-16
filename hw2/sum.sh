#!/bin/bash

if [[ ! $# -eq 2 ]] ; then
    echo "Error: You must enter two numbers" >&2; exit 1
else
    for i in $@ ; do
        if ! [[  ${i} =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]] ; then
            echo "Error: Param \"${i}\" is not a number" >&2 ; exit 1
        fi
    done
fi

echo -n "Result: "
echo $1 + $2 | bc