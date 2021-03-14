#!/bin/bash
re='^[+-]?[0-9]+([.][0-9]+)?$';
if !  [[ $1 =~ $re ]] || ! [[ $2 =~ $re ]]
then
   echo "error: Я могу сложить только цифры";
   exit 1;
else
   echo $1'+'$2 | bc -l;
fi
