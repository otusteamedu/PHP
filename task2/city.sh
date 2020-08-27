#!/bin/bash

filename=$1

# check inputs
if [ $# -ne 1 ]
then
    echo "error: incorrect input arguments"
    exit 10
fi

if [ ! -f "$filename" ]
then
    echo "error: file \"$filename\" not exist"
    exit 11
fi

# script body
awk -f city.awk "$filename" | sort | uniq -c | sort -nr | head -n 3

exit 0