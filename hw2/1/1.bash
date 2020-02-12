#!/bin/bash
re='^[-+]?[0-9]+\.?[0-9]*$'
if ! [[ $1 ]] || ! [[ $1 =~ $re ]]; then
   echo "error: 1 parameter is required and it must be a number" >&2; exit 1
fi
if ! [[ $2 ]] || ! [[ $2 =~ $re ]]; then
   echo "error: 2 parameter is required and it must be a number" >&2; exit 1
fi
echo $1 + $2 | bc
exit 0
