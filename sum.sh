#!/bin/bash

error=0
REGEX_NUMBER="^-?[0-9]*[.]?[0-9]+$"

bc=`dpkg -s bc | grep "Status"`
if [[ -z $bc ]]
then
   echo "This script requires 'bc' package. Use the command 'apt install bc' to install it"
   error=1
fi

if [[ $# -ne 2 ]]
then
  echo "Requires two parameters"
  error=1
elif ! [[ $1 =~ $REGEX_NUMBER ]]
then
  echo "The first parameter is not a number"
  error=1
elif ! [[ $2 =~ $REGEX_NUMBER ]]
then
  echo "The second parameter is not a number"
  error=1
fi

if [[ $error -eq 1 ]]
then
  exit 1
fi

sum=$(echo "$1+$2" | bc -l)
echo "$1 + $2 = $sum"
exit 0
