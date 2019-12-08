#!/usr/bin/env bash

if [[ $1 == "" ]]
then
    echo "Filename requires"
    exit 1
fi

awk -F"[[:space:]]" '$3 != "" { print $3 }' $1 | sort | uniq -c | sort --key=6,7 -r | head -n 3 | awk '{ print $2 }'
exit 0
