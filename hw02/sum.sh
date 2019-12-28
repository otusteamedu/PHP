#!/bin/bash

a=$1
b=$2

isNum(){
  if [[ -z "$1" || ! "$1" =~ ^-?[0-9]+(\.[0-9]+)?$ ]]
  then
   return 0;
  else
   return 1;
  fi;
}

if (isNum $a -eq 0)
then
  echo "wrong first argument"
  exit;
fi

if (isNum $b -eq 0)
then
  echo "wrong second argument"
  exit;
fi

echo "$(echo "$a + $b" | bc)";


