#!/bin/bash

is_num="^[0-9]+$"

if [[  $1 =~ $is_num && $2 =~ $is_num ]]; then
	echo $(($1+$2))
else
	echo "error! not a number"
fi
