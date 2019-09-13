#!/bin/bash  
var1=$1 
var2=$2 

re='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $var1 =~ $re ]]&&[[ $var2 =~ $re ]] ; then
   echo "error: Not a number" >&2; exit 1
fi

#echo "Script is $0, arguments are $var1 and $var2 (total $#)"
INT=$(($var1+$var2)) 
echo $INT





