#!/bin/bash

program='Summer v0.1.0'

if [[ $# -lt 2 ]]; then
	echo -e $program
	echo 'Enter at least 2 parameters for summation!'
	exit 1
fi

result=0

for param in "$@"
do
	if [[ $param -eq $param ]]; 
	then
		result=$(( $result + $param ))
	else
		echo "'$param' type must be integer"
	fi
done

echo "The sum is: $result"
exit 0
