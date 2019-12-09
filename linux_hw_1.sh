#!/bin/bash
if [ $# -ne "2" ]; then
  echo "Order of use: $0 logged_1 logged_2"
  exit 65
fi
if [ -z "$(echo $1 | awk '/^[0-9\.\-]*$/{print $0}')" -o -z "$(echo $2 | awk '/^[0-9\.\-]*$/{print $0}')" ]; then
  echo "Order of use: $0 numeric numeric"
  exit 65
fi
echo $(echo "; $1+$2" | bc)
exit 0
