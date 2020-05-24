#!/bin/bash
rule="^[-+]?[0-9]*\.?[0-9]*$"
if [[ ! $1 =~ $rule || ! $2 =~ $rule || $# != 2 ]]; then
	>&2 echo "Error: Invalid parameters"
	exit 1
fi
echo "Result" $(echo $1 + $2 | bc)
exit 0
