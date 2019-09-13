#!/bin/bash
read -p "First num: " f_num
read -p "Second num: " s_num

re='^[0-9]+([.][0-9]+)?$'
if ! [[  $f_num =~ $re ]] ; then
   echo "error: First num not a number" >&2; exit 1
fi

if ! [[  $s_num =~ $re ]] ; then
   echo "error: Second num not a number" >&2; exit 1
fi

echo "$f_num+$s_num" |awk '{split($0,a,"+"); $res=a[1]+a[2]; print $res}'
