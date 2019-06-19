#!/bin/bash
if ! [ $# -eq 2 ]
then
    echo "Two arg needed"
elif ! (echo "$1" | grep -E -q "^-?[0-9]+$"); then
    echo "first arg is not integer type"
elif ! (echo "$2" | grep -E -q "^-?[0-9]+$"); then
    echo "secont arg is not integer type"
else
    sum=$(("$1+$2"))
    echo "$sum"
fi
