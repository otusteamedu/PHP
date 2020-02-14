#!/bin/bash
reg="^(-?[0-9]+(\.[0-9]+)?)$"
if [[ ! $1 =~ $reg ]] || [[ ! $2 =~ $reg ]]; then
echo "invalid parameters"
else
echo $1 + $2 | bc
fi
exit 0