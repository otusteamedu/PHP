#!/usr/bin/env bash

firstArgument=$1
secondArgument=$2

isNumber() {
  [[ $1 =~ ^-?[0-9]+([.][0-9]+)?$ ]]
}

if [[ $# < 2 ]]; then
    echo "Script expects 2 arguments, $# given"
    exit
fi

while ! isNumber $firstArgument; do
  read -p "$firstArgument is not a number: " firstArgument
done

while ! isNumber $secondArgument; do
  read -p "$secondArgument is not a number: " secondArgument
done

echo | awk "{print $1 + $2}"
