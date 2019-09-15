#!/bin/bash

re='^([-,0-9])+([.][0-9]+)?$'
if ! [[  $1 =~ $re ]] ; then
   echo "error: First num not a number" >&2; exit 1
fi

if ! [[  $2 =~ $re ]] ; then
   echo "error: Second num not a number" >&2; exit 1
fi

echo "$1+$2" |awk '{split($0,a,"+"); $res=a[1]+a[2]; print $res}'
