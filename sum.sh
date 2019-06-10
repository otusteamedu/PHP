#!/bin/bash
  
if [ "$1" -eq "$1" ] 2>/dev/null && [ "$2" -eq "$2" ] 2>/dev/null; then
	sum=$((${1} + ${2}))
	echo "${sum}"
else
	echo "Invalid arguments. Only integers allowed"
fi
