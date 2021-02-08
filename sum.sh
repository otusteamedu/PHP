#!/bin/bash


number1=$1
number2=$2
regex=^-?[0-9]+\(\.[0-9]+\)?$

function errorMessage {
	echo "$1 is not number"
}

if [[ $# -ne 2 ]]; then
	echo "Usage: $(basename $0) number1 number2"
	exit 1
fi

if ! [[ "$number1" =~ $regex ]]; then
	errorMessage $number1
	exit 1
elif ! [[ "$number2" =~ $regex ]]; then
	errorMessage $number2
	exit 1
fi

result=$(echo "$number1+$number2" | bc -l)

echo $result

exit 0

