#!/bin/bash

arg1=$1
arg2=$2
re='^[0-9]+$'

if [[ $arg1 =~ $re &&  $arg2 =~ $re ]] ; then
    echo $(($arg1 + $arg2))
else
    echo "error: Bad argument(s). Not a number"
    exit 1
fi