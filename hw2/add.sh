#!/bin/bash
test_for_digit() {
    if [ "$1" -eq "$1" ] 2>/dev/null; then
        return 0
    else
        return 1
    fi
}

echo "Addition script"
if [[ $# < 2 ]]; then
    echo "2 parameters needed!"
    exit 1
else
    if test_for_digit "$1" && test_for_digit "$2"; then
        test_for_digit $1
        awk "BEGIN { print \"Result:\", $1 + $2; exit }"
        exit 0
    else
        echo "Parameters needs to be a numbers!"
        exit 1
    fi
fi

