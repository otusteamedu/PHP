#!/bin/bash
if [ "$#" = 2 ] && [[ "$1" == +([0-9]) ]] && [[ "$2" == +([0-9]) ]]
then
let summ=$1+$2
#echo $1 + $2 = "$summ"
echo $summ
else
exit "ERROR: Must be 2 numeric parametrs"
fi