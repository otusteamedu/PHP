#!/bin/bash

file=$1

if [ -s "$file" ]; then
    echo "Пуст или несуществует"
    exit 1
fi

exit 0
