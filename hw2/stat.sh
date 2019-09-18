#!/usr/bin/env bash
#echo $1
if [[ $# -ne 1 ]]
 then
   echo "Error. Input file name!"
   exit 1
fi

if [[ ! -e $1 ]]
 then
   echo "Error. File does not exist"
   exit 1
fi

res=$(awk '{print $3}' $1|sort|uniq -c|sort -nr|head -3)
echo $res