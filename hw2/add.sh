#!/bin/bash
test_for_digit() {
    [[ "$1" =~ ^[+-]?([0-9]+\.?|[0-9]*\.[0-9]+)$ ]] && return 0
}

echo "Addition script"
if [[ $# -lt 2 ]]; then
    echo "2 parameters needed!"
    exit 1
else
    if test_for_digit "$1" -eq 0 && test_for_digit "$2" -eq 0; then
        awk "BEGIN { print \"Result:\", $1 + $2; exit }"
        exit 0
    else
        echo "Parameters needs to be a numbers!"
        exit 1
    fi
fi
