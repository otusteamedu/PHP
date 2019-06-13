#!/bin/bash

for var in $1 $2
do
    if ! [[ $var =~ [[:digit:]] ]]; then
        echo "$var is not a number"
        exit 1
    fi
done

echo $1 + $2 | bc
