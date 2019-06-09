#!/bin/bash
first_arg=$1
second_arg=$2
regexp_number='^-?[0-9]+\.?[0-9]*$'

if [[ $first_arg =~ $regexp_number ]] && [[ $second_arg =~ $regexp_number ]]
	then
		echo $first_arg + $second_arg | bc
else
	echo "Invalid input. Arguments must be valid numbers."
fi
