#!/bin/bash

NUM1=$1
NUM2=$2

if [[ -z "$NUM1" || -z "$NUM2" ]]; then
    echo "Two numbers must be passed";
    exit 1;
fi

if [[ $NUM1 =~ [^0-9\.-] || $NUM1 =~ -{2,}  || $NUM1 =~ -$ ]]; then
    echo "Incorrect number format \"$NUM1\"";
    exit 1;
fi

if [[ $NUM2 =~ [^0-9\.-] || $NUM2 =~ -{2,} || $NUM2 =~ -$ ]]; then
    echo "Incorrect number format \"$NUM2\"";
    exit 1;
fi

echo "$NUM1 + $NUM2" | bc
