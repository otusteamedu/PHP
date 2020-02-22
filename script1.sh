#!/bin/bash
re='^[+-]?[0-9]+([.][0-9]+)?$'

if [[ $1 =~ $re && $2 =~ $re ]] ; then

	let "a = $1 + $2"
	echo $a

else  echo "error: Not a number" >&2; exit 1
fi
