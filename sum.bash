#!/bin/bash

if [ "$#" -ne 2 ]; then
    echo Print the sum of two operands
    echo "Usage: $( basename "$0" ) <op0> <op1>"
    exit
fi

echo "$1$2" | grep -qE "^[[:digit:]]+\$" || {
    echo "Expecting two numbers as parameters!"
    exit 1
}

echo $(( $1 + $2 ))
