#!/bin/bash

if [[ $1 ]]; then
	cat $1 | sort -rnk4 | awk -F' ' {'print $4,$3'} | head -n 3
else
	echo "not arguments"
fi
