#!/bin/bash

if [ -z "$2" ]
then
    echo "Error: Second argument can't be empty" >&2
else
    re='^[+-]?[0-9]+([.][0-9]+)?$'
    
    if [[ $1 =~ $re ]] && [[ $2 =~ $re ]]
    then
        echo -n 'Result: '
        echo `echo $1 + $2 | bc`

    else
        echo "Error: Arguments must be numbers" >&2
    fi
fi
