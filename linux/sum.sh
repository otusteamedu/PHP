#!/bin/bash

re='^-?[0-9]+(\.{1}[0-9]+)*$'

if ! [[ $1 =~ $re ]] ; then
   echo "error: Argument '$1' is not a number"; exit 1
fi
if ! [[ $2 =~ $re ]] ; then
   echo "error: Argument '$2' is not a number"; exit 1
fi

awk "BEGIN{ print $1+$2 }"
