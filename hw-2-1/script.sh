#!/bin/bash

if [[ $# -lt 2 ]]; then
    echo "Error. At least 2 arguments expected, $# given" >&2
    exit
fi

isNumber() {
    [[ $1 =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]
}

count=1
summ=0

for param in "$@"
do
    if ! isNumber $param; then
        echo "Error. Argument #$count is not a number" >&2
        exit
    else
        summ=$(echo "$summ + $param" | bc)
        count=$(( $count + 1 ))
    fi
done

echo $summ
