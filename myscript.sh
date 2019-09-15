#!/bin/bash  
var1=$1 
var2=$2 

re='^[+-]?[0-9]+([.][0-9]+)?$'


if ! ([[ $var2 =~ $re ]]||[[ $var1 =~ $re ]]); then
   echo "error: First and Second input Not a number" >&2; exit 1
fi
if ! [[ $var1 =~ $re ]] ; then
   echo "error: First input not a number" >&2; exit 1
fi

if ! [[ $var2 =~ $re ]] ; then
   echo "error: Second input Not a number" >&2; exit 1
fi

#echo "Script is $0, arguments are $var1 and $var2 (total $#)"

echo $var1 $var2| awk '{ sum += $1+$2 } END { print sum }'


