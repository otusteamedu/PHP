#!/bin/bash

if [ "$#" -ne 2 ]; then
    echo Print the sum of two operands
    echo "Usage: $( basename "$0" ) <op0> <op1>"
    exit
fi

_op0="$( echo "$1" | tr --delete --complement "[:digit:]" )"
_op1="$( echo "$2" | tr --delete --complement "[:digit:]" )"

if ! [ "$1" -a "$2" -a "$1" = "$_op0" -a "$2" = "$_op1"  ]; then
    echo "Expecting two numbers as parameters!"
    exit 1
fi >&2

echo $(( $_op0 + $_op1 ))
