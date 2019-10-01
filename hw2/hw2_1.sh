#!bin/bash
number='^-?[0-9]+(\.[0-9]+)?$'
if [[ $# == 2 ]] && [[ $1 =~ $number ]] && [[ $2 =~ $number ]]
then
    first=$1
    second=$2
    echo $first + $second | bc
else
    echo "Error - need two numbers"
fi