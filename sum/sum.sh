#!/bin/bash

num_parameters=2
regex='^-?[0-9]+(\.[0-9]+)?$'

#validation
if [[ $# -ne num_parameters ]]
then
echo >&2 'Expected two arguments'
exit 1
fi

for var in $@
do
  #condition true on return zero
  if ! [[ $var =~ $regex ]]
  then
    echo "this is not a number: $var"
    exit 1
  fi
done
#end validation

sum=$(bc <<< "$1 + $2")
echo $1+$2=$sum

