#!/bin/bash
# exit code:
#   0 - success
#   10 - count of parameters not equal 2
#   11 - parameter 1 is not real number
#   12 - parameter 2 is not real number


param1=$1
param2=$2


# check input params
if [ $# -ne 2 ]
then
    echo 'error: check params count'
    exit 10 #params error code
fi


if [[ $param1 =~ ^-?[0-9]+\.?[0-9]*$ ]]
then
    #echo "param1 ok"
    echo "param1 ok" > /dev/null
else
    echo "error: param1 is incorrect"
    exit 11 #params error code
fi


if [[ $param2 =~ ^-?[0-9]+\.?[0-9]*$ ]]
then
    #echo "param2 ok"
    echo "param2 ok" > /dev/null
else
    echo "error: param2 is incorrect"
    exit 12 #params error code
fi

# math operation with real numbers
bc <<< $param1+$param2

exit 0