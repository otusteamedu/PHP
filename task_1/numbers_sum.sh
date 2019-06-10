#!/bin/bash

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $re ]] || ! [[ $2 =~ $re  ]] ; then
   echo "error: One or both arguments not a number. You input: $1 and $2" >&1; exit 1
fi

sum=`echo "$1 + $2" | bc`
echo "Result: $1 + $2 = $sum."
