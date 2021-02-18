#!/bin/bash
if [[ $# -ne 2 ]]
then
  echo "Need to pass two parameters. $# given."
  exit 1
fi

term1=$1
term2=$2

reg_exp='^\-?[0-9]*\.?[0-9]+$'
if ! echo "$term1" | grep -qE $reg_exp
then
    echo "Parameter 1 is not a number."
    exit 2
fi

if ! echo "$term2" | grep -qE $reg_exp
then
    echo "Parameter 2 is not a number."
    exit 3
fi

sum=$(echo "$term1 + $term2" | bc)

echo $sum
exit 0