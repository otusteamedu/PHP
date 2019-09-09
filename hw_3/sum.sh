#!/bin/bash

if [ "$1" -eq "$1" ] 2>/dev/null && [ "$2" -eq "$2" ] 2>/dev/null; then
	echo $((${1} + ${2}))
else
	echo "Invalid arguments. Only integers allowed"
fi
