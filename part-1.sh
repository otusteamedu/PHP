#!/bin/bash
first=$1
second=$2

if [ -z "$second" ]; then
  echo "Script requires two arguments. "
fi

re='^[0-9]+([.][0-9]+)?$'
if ! [[ $first =~ $re && $second =~ $re ]] ; then
   echo "error: Not a number" >&2; exit 1
fi

# echo $((first + second))
awk "BEGIN {print $first+$second}"