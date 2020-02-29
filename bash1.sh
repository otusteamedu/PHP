#!/bin/bash
re='^[+-]?[0-9]+([.][0-9]+)?$'

if ! [[ $1 =~ $re ]]
then
    echo "error: 1 is not a number" >&2; exit 1
fi
if ! [[ $2 =~ $re ]]
then
    echo "error: 2 is not a number" >&2; exit 1
fi
echo "$1 $2" | awk '{print $1 + $2}'