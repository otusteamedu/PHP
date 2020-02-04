#!/bin/bash
# exit codes:
#  0 - Success
#  10 - Arguments array has a not numeric input

# Result
res=0

# All arguments input in command line
params=$@

# Main loop for each input argument
for param in ${params}
do
# Check whether input contains literals
    if [[ ${param} =~  ^-?[0-9]+\.?[0-9]*$ ]]
    then
        res=$(echo "$param" + "$res" |bc)
    else
        echo 'error: Incorrect input'
        exit 10
    fi
done

# Send result into standard output
echo ${res}
