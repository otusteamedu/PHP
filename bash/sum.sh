#!/usr/bin/bash

param1=$1
if !(echo "$param1" | grep -E -q "^?[0-9]+$"); 
then
	echo "First parameter must be a number"
	exit 1
fi

param2=$2
if !(echo "$param2" | grep -E -q "^?[0-9]+$"); 
then
	echo "Second parameter must be a number"
	exit 1
fi

echo $param1 + $param2 | bc