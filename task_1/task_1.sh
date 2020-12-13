#!/bin/bash
REGEX="^\-?[[:digit:]]+(\.[[:digit:]]+)?$"
SUM=0
ARG_COUNT=$#

for (( i=1; i<=$ARG_COUNT; i++ ))
do
	if [[ ${!i} =~ $REGEX ]]; then
		SUM=`echo $SUM + ${!i} | bc`
	else
		echo "Argument $i is invalid: ${!i}" >&2
		exit 1
	fi
done
echo "$SUM"
