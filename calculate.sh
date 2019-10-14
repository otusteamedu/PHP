#!/bin/bash

float='^-?[0-9]+(\.[0-9]+)?$'
if ([[ $# == 2 ]] && [[ $1 =~ $float ]] && [[ $2 =~ $float ]])
then
    echo $1 + $2 = $(awk "BEGIN {print $1+$2;}")
else
    echo "Arguments should be two float"
fi
