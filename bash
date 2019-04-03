#!/bin/bash

error=false
reg='^[0-9]+$'

if [ "$#" != 2 ]; then
  echo "error: 2 parameters required"
  exit 1
fi

function chkArgs {
   if ![[ $1 = ${reg} ]] 
        echo "error: $1 is not a number"
        error=true
   fi            
}

chkArgs $1
chkArgs $2

if [[ ${error} == true]] then exit 1

fi

   

echo $1 $2 | awk '{print $1 + $2}'