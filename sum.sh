#!/usr/bin/env bash

if (( $# != 2 )); then
    echo "Two numbers needed"
    exit 1
fi

error=false
regexp='^[+-]?[0-9]+([.][0-9]+)?$'
function checkArgument {
    if ! [[ $1 =~ ${regexp} ]]
	then
	   echo "error: \"$1\" not a number" >&2
	   error=true
	fi 
}

checkArgument $1
checkArgument $2

if [[ true == ${error} ]]
then exit 1
fi

echo $1 $2 | awk '{print $1 + $2}'
