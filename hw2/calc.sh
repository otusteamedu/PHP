#!/usr/bin/env bash
# echo $@;
#echo $#
clear
if [[ $# -ne 2 ]]
 then
   echo "Error. Input two numbers!"
   exit 1
fi

regex='^-?[0-9.]*$'

for i in "$@"
do
 if [[ ! $i =~ $regex ]]
then
  echo "$i -Input is not a number " >&2
exit 1
fi
done

echo $(awk "BEGIN {print $1+$2; exit}")








