#!/bin/bash
param1=$1
param2=$2

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $param1 =~ $re && $param2 =~ $re  ]] ; then
   echo "error: please, enter a numbers" >&2; exit 1
fi

result=$(echo "$param1+$param2" | bc)
echo "Результат ${param1} + ${param2} = ${result}"
