#!/bin/bash

first=$1  #первое число на вход
second=$2 #второе число на вход

regex='^[-+]?[0-9]*\.?[0-9]+$'

if [ "$#" -lt 2 ] || [ "$#" -gt 2 ]; then
  echo "2 parameters must be passed"
  exit 1
fi

if [[ "$first" =~ $regex ]] & [[ "$second" =~ $regex ]]; then
  result=$(echo "$first+$second" | bc -l | sed -r 's/^(-?)\./\10./')
  echo "$result"
  exit 0
else
  echo "one of parameters is not valid"
  exit 1
fi
