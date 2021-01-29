#!/bin/bash

if [[ -z $1 ]]
then
    echo "File name parametr need!"
    exit 1
fi

cat $1 | awk {'print $3'} | sort | uniq -d -i | head -3

exit 0
