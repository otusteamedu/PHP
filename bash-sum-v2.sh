#!/bin/bash

program='Summer v0.1.0'

if [[ $# -lt 2 ]]; then
	echo -e $program
	echo 'Enter at least 2 parameters for summation!'
	exit 1
fi

result=0
errors=0
regex='^(-?[1-9]{1}\d*|0)$'

for param in "$@"
do
	if [[ $param =~ $regex ]]; 
	then
		result=$(( $result + $param ))
	else
		echo "'$param' type must be integer"
		errors=$(( $errors + 1 ))
	fi
done

if [[ $errors -eq 0 ]];
then
	echo "The sum is: $result"
fi

exit 0
