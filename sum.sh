#!/usr/bin/env bash
regexp='^[0-9]+$'
if ! [[ $1 =~ $regexp ]] ; then
   echo "error: $1 is not a integer"; exit 1
fi
if ! [[ $2 =~ $regexp ]] ; then
   echo "error: $2  is not a integer"; exit 1
fi
echo $[$1 + $2]
