#!/bin/bash
if [ $# -ne "1" ]; then
  echo "Order of use: $0 file.txt"
  exit 65
fi
awk '{ a[$3] += 1 } END {for(k in a) print k " " a[k]}' $1 | sort -r -k2 -n | awk '{ print $1 }' | head -n 3
exit 0