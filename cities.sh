#!/bin/bash

FILENAME=$1

if ! [[ -f "$FILENAME" ]]; then
	echo "Usage: $(basename $0) filename"
	exit 1
fi

awk 'NR != 1 { print $3 }' $FILENAME | sort | uniq -c | sort -r | awk '{print $2 " - " $1}' | head -3 | sort -k1
