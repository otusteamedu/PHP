#!/bin/bash

validate_input(){
  regexp="^-?[0-9]+(\.[0-9]+)?$"

  if ! [[ $1 =~ $regexp ]]; then
    echo invalid input: not number
    exit 1
  fi
}

read -p "Input number 1: " n1
validate_input $n1

read -p "Input number 2: " n2
validate_input $n2

#echo SUM:
#echo $n1 + $n2 | bc

echo $n1 $n2 | awk '{print "sum: " $1 " + " $2 " = "  $1 + $2}'
