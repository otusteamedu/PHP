#!/bin/bash

#sum=$(($1+$2)) not working for floats so use bc
if [[ $# < 2 ]]; then
	 echo "not enough args, dude"
	 exit;
fi
if [[ $1 =~ ^-?[0-9]+([.][0-9]+)?$ ]]&&[[ $2 =~ ^-?[0-9]+([.][0-9]+)?$ ]]; then 
	echo $1+$2|bc;
	exit;
else
	echo "we need two digits, bro"
	exit;
fi
