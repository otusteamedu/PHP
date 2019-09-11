#!/bin/bash
A1=$1
A2=$2
NUM_REGEXP='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $A1 =~ $NUM_REGEXP && $A2 =~ $NUM_REGEXP ]] ;
then
    echo "Both parameters should be numbers";
    exit 1
fi
echo $A1 + $A2 | bc
