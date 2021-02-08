# !bin/bash

reg='^[+-]?[0-9]+([.][0-9]+)?$'
if ! [[ $1 =~ $reg && $2 =~ $reg ]]
then 
   echo "Error: Not a number"
else
   summ=$(echo "$1 + $2" | bc)
   echo $summ
fi
