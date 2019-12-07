#!/bin/bash

isValidNumber() {	
	if ( [[ "$1" =~ ^\-?[0-9]+(\.[0-9]+)?$ ]])
	   then		   
		   return 1
	   else		   
		   return 0
	fi
}

a=$1
b=$2
if ( isValidNumber $a -eq 0 || isValidNumber $b -eq 0 )
then
	echo "параметры должны быть заданы числами"
	exit 1
fi
echo "сумма: `bc <<< $a+$b`"
