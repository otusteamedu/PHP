#!bin/bash
number='^-?[0-9]+$'
if [[ $# == 2 ]] && [[ $1 =~ $number ]] && [[ $2 =~ $number ]]
then
    sum=$(($1 + $2))
    echo $sum
else
    echo "Error - need two integers"
fi