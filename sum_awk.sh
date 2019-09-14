 #!/bin/bash
if [ ! $# -eq 2 ]; then
   echo 'Error: You should pass 2 numbers' >&2
else
    for number in $@
    do
        if [[ ! $number =~ ^-?[0-9].?[0-9]?+$ ]]; then
            echo "Error: '$number' is not a number" >&2
            exit 1
        fi
    done
    echo "$1|$2" | awk -F'|' '{sum = $1 + $2} END {print sum}'
fi
