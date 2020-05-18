#!/bin/bash

function is_valid {
if [[ "$1" =~ ^-?[0-9]+[\.|\,][0-9]+$ ]]; then
return 0
else
return 1
fi
}

NUM1="$1"
echo "First argument: $NUM1"

NUM2="$2"
echo "Second argument: $NUM2"

if is_valid "$NUM1"; then
echo "Fisrt argument is float!"
exit 1
fi
#
#if is_float "$NUM2"; then
#echo "Second argument is float!"
#fi

#RESULT=`echo "$NUM1+$NUM2" | bc -l`
#echo $RESULT
