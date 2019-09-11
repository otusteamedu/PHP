#!/bin/bash

if ! [ $# -eq 2 ]; then
	echo "Error: command takes two numbers" >&2
	exit 1
else
	if ! [[ "$1" =~ ^\-?[[:digit:]]+(\.[[:digit:]]+)?$ ]]; then
		echo "The first argument must be a number" >&2
		exit 2
	fi
	if ! [[ "$2" =~ ^\-?[[:digit:]]+([\.][[:digit:]]+)?$ ]]; then
                echo "The second argument must be a number" >&2
                exit 3
        fi
fi

printf "%s + %s = %s\n" "$1" "$2" "$( bc <<<"$1 + $2" )"
