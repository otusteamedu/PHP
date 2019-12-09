#!/bin/bash

filename=$1


#check inputs
if [ $# -ne 1 ]
then
    echo "Incorrect input arguments"
    exit 10
fi

if [ ! -f "$filename" ]
then
    echo "file \"$filename\" not exist"
    exit 11
fi




exit 0