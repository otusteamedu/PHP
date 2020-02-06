#!/bin/bash

arg=$1

if [[ $# -ne 1 ]]
then
  echo "ERROR: Wrong argument (CODE 10)"
  exit 10
fi

if [[ ! -f "$arg" ]]
then
  echo "ERROR: File \"$arg\" not found (CODE 11)"
  exit 11
fi

# Main script
awk -f myscript.awk "$arg" | sort | uniq -c | sort -nr | head -n 3

exit 0
