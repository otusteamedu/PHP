#!/bin/bash
# exit codes:
#  0 - Success
#  10 - Argument is not numeric
#  11 - Count of arguments is not equal 2


arg1=$1
arg2=$2

# Check if the count of args is equal 2
if [[ $# -ne 2 ]]
then
    echo 'error: Wrong arguments count'
    exit 11
fi

# Check input value is numeric
if [[ ${arg1} =~  ^-?[0-9]+\.?[0-9]*$ && ${arg2} =~ ^-?[0-9]+\.?[0-9]*$ ]]
then
    echo 'OK!' > /dev/null
else
    echo 'error: Incorrect input'
    exit 10
fi

bc <<< ${arg1}+${arg2}

exit 0