#!/bin/bash
#

function is_digit {
   echo $1 | grep -E -q '^-?[0-9]+$'
   echo $?
}

if [[ $# -eq 2 ]]
then 
    export OP1=`is_digit $1`
    export OP2=`is_digit $2`
    if [[ $OP1 -eq 0 && $OP2 -eq 0 ]]
    then
        echo $(($1+$2))
        exit
    fi
fi
echo "Usage: $0 <integer operand 1> <integer operand 2>"

