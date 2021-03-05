#!/bin/bash

x=$1
y=$2
regexp='^\-?[0-9]+(\.[0-9]+)?$'

if [[ ! $x =~ $regexp || ! $y =~ $regexp ]]; then
  echo 'invalid arguments'

  exit 1
fi

echo $(echo $x + $y | bc)

exit 0