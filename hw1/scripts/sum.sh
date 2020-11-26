#!/bin/bash
sum=0
args=$#
regex="^\-?[[:digit:]]+(\.[[:digit:]]+)?$"

for (( i=1; i<=$args; i++ ))
do
	if [[ ${!i} =~ $regex ]];
	then
		sum=`echo $sum + ${!i} | bc`
	else
		echo -e "\e[101m Argument $i is invalid: ${!i}" >&2
		exit 1
	fi
done
echo "$sum"