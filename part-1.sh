#!/bin/bash
first=$1
second=$2

if [ -z "$second" ]; then
  echo "Script requires two arguments. "
fi

while ! [[ $first =~ ^-?[0-9]+[.]?[0-9]*$ ]]; do
  echo "First argument not a nunber"
  read first
done

while ! [[ $second =~ ^-?[0-9]+[.]?[0-9]*$ ]]; do
  echo "Second argument not a nunber"
  read second
done

echo $first + $second | bc