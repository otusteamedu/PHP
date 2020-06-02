#!/bin/bash
re='?(-)+([0-9]*|[.,][0-9])'
[[ $1 && $2 == $re ]] && echo "$1+$2" | bc || echo "is not a number";