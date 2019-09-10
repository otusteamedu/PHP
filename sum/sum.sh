#!/bin/bash

digitalRegex=^[0-9]+$

if [ ! $# -eq 2 ]; then
   echo 'Error: Wrong arguments count' >&2
   exit 1
fi

for argument in $@
do
    if [[ ! $argument =~ $digitalRegex ]]; then
        echo "Error: '$argument' is not a number" >&2
        exit 1
    fi
done

echo $(($1 + $2))
