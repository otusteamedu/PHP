#!/bin/bash

if [[ $1 ]]; then
	cat $1 | awk '{print $3}' | sort | uniq -c | sort -nr | head -3
else
	echo "not arguments"
fi
