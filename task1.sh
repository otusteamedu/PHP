#!/usr/bin/env bash

numberRegex="[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?"

if ! [[ $1 =~ ^$numberRegex$ ]]
then
    echo "First argument is not a number! $1"
    exit 1
fi

if ! [[ $2 =~ ^$numberRegex$ ]]
then
    echo "Second argument is not a number! $2"
    exit 1
fi

echo $(awk "BEGIN {print $1+$2; exit}")
exit 0
