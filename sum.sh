#!/bin/bash

isValid="^(\-)*[0-9]+(\.[0-9]+)*$"

if [[ $1 == "" || $2 == "" ]]; then
	printf "Write two digits like sum.sh 12 123.23\n"
	exit 1
fi

if [[ ! $1 =~ $isValid ]]; then
	echo "Num 1 is invalid format"
	exit 1
fi

if [[ ! $2 =~ $isValid ]]; then
	echo "Num 2 is invalid format"
	exit 1
fi

echo $1+$2 | bc
