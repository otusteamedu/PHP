#!/bin/bash
total=$(echo "$1+$2" | bc)
re='?(-)+([0-9]*|[.,][0-9])'
[[ $1 && $2 == $re ]] && echo "The sum is $total" || echo "is not a number";