#!/usr/bin/env bash

regex='^-?[0-9]+(.[0-9]+)?$'

if [[ $1 =~ $regex ]] && [[ $2 =~ $regex ]]
then
  bc <<< "$1 + $2"
else
  echo "Error: Arguments must be a number!" >&2; exit 1
fi