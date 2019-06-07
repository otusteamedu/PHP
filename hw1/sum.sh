#!/bin/bash
arg1=$1
arg2=$2

if [ -z "$arg2" ]
then
    echo "Error: Second argument can't be empty" >&2
else
    re='^[+-]?[0-9]+([.][0-9]+)?$'
    
    if [[ $arg1 =~ $re ]] && [[ $arg2 =~ $re ]]
    then
        echo -n 'Result: '
        echo `echo $arg1 + $arg2 | bc`

    else
        echo "Error: Arguments must be numbers" >&2
    fi
fi