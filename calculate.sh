#!/bin/bash

int='^-?[0-9]+$'
if ([[ $# == 2 ]] && [[ $1 =~ $int ]] && [[ $2 =~ $int ]])
then
    echo $1 + $2 = $(($1+$2))
else
    echo "Arguments should be two integers"
fi
