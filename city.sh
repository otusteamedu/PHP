#!/bin/bash

if [[ $# != 1 ]]
then
    echo "Filename argument required"
    exit
fi

if [[  -f $1 ]]
then
    awk '{print$3}' $1 | sort | uniq -c | sort -r | awk '{print$2}'| head -n3
else
    echo "Fine not found"
fi
