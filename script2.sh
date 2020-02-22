#!/bin/bash

if [[ $1 ]]; then
	cat $1 | awk '{print $3}' | sort | uniq -c | sort -r | head -3
else
	echo "not arguments"
fi
