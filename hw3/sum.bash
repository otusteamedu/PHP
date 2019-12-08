#!/bin/bash
reg="grep -E -q ^[-+]?[0-9]+\.?[0-9]*$"
if ((!(echo $1 | $reg)) || (!(echo $2 | $reg))); 
then
   echo 'Некорректный ввод, повторите попытку'
   exit 1
fi
echo $1 $2 | awk '{print $1 + $2}'
exit 0