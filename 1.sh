#!/bin/bash
#OTUS PHP-11-2019

if [[ -n $1 && -n $2 ]]; then 
	d1=$1
	d2=$2
else
	read d1 d2
fi

is_number () {
  	pattern='^[+-]?[0-9]+([.][0-9]+)?$'
	if ! [[ $1 =~ $pattern ]] ; then
	   echo "Please enter numbers only" >&2; exit 1
	fi
}

if ( is_number $d1 ) && ( is_number $d2 ); then
	echo $d1 '+' $d2 |bc
fi