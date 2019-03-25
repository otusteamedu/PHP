#!/bin/bash

# Validate arguments number
if (( $# != 2 )); then
    echo "Use two numbers as a parametes"
    exit 1
fi

# Validate arguments values
i=0
for number in "$@"; do
    ((i++))
    if ! [[ $number =~ ^[+-]?[0-9]+([.][0-9]+)?$ ]]; then
        errors=(${errors[@]}$i' argument is not a valid number\n')
    fi
done

# Exit if validation fails
if ! [ ${#errors[@]} -eq 0 ]; then
    echo -e "${errors[@]}" >&2
    exit 1
fi

# Do the stuff. bc for floats support
echo $1 + $2 | bc
