#!/bin/bash
if [ -z "$2" ]; then
  echo "Script requires two arguments. "
fi

if ! [[ $1 =~ ^-?[0-9]+[.]?[0-9]*$ ]]; then
  echo "First argument not a nunber"
elif ! [[ $2 =~ ^-?[0-9]+[.]?[0-9]*$ ]]; then
  echo "Second argument not a nunber"
else
  echo $1 + $2 | bc
fi
