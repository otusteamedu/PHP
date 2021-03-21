#!/bin/bash

checkInt='^[-0-9]+$'
checkFloat='^[-0-9]+\.[0-9]+$'

if [[ $1 =~ $checkNum ||  $1 =~ $checkFloat ]] && [[ $2 =~ $checkNum  ||  $2 =~ $checkFloat ]]
then
  echo "$1 + $2" | bc -l
else
    echo "Один из аргументов не является числом"
fi
