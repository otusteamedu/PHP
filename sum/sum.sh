#!/bin/bash
regex="^-?[[:digit:]]+$"
if [[ $1 =~ $regex ]] && [[ $2 =~ $regex ]]; then
  echo $(($1 + $2))
else
  echo "first or second argument is not a number"
fi
