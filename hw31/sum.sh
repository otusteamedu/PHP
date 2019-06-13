#! /bin/bash

if ( echo $1 | grep -E -q "^-?[0-9]+$" && echo $2 | grep -E -q "^-?[0-9]+$" )
then
	let "c = $1 + $2"
	echo $c
else
	echo "Одно из операндов не является числом."
fi

