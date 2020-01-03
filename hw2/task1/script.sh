#!/bin/bash

if [[ $# -lt 2 ]]; then
    echo "Недостатачно пораметров"
    exit 1
fi
pattern="^-?[0-9]+\.?[0-9]*$"
first=$1
second=$2
if [[ !($first =~ $pattern) ]]; then
    echo "Валидаций параметра \`$first\` не пройдена"
    exit 1
fi
if [[ !($second =~ $pattern) ]]; then
    echo "Валидаций параметра \`$b\` не пройдена"
    exit 1
fi

first_array=(${first//./ })
second_array=(${second//./ })

first_full=${first_array[0]}
second_full=${second_array[0]}

if [[ ${#first_array[*]} == 2 ]]; then
    first_fraction=${first_array[1]}
fi
if [[ ${#second_array[*]} == 2 ]]; then
    second_fraction=${second_array[1]}
fi

first_fraction_length=${#first_fraction}
second_fraction_length=${#second_fraction}
max_fraction_length=0
first="${first_full}${first_fraction}"
second="${second_full}${second_fraction}"


if [[ ${first_fraction_length} -gt ${second_fraction_length} ]]; then
    max_fraction_length=${first_fraction_length}
    for ((i = 0; i < $(( $first_fraction_length - $second_fraction_length)); i++)); do
        second="${second}0"
    done
    else
    max_fraction_length=${second_fraction_length}
    for ((i = 0; i < $(( $second_fraction_length - $first_fraction_length)); i++)); do
        first="${first}0"
    done
fi

result=$(( first + second))

result_length=${#result}
dot_position=$((result_length - max_fraction_length))
for ((i = 0; i < $result_length; i++)); do
    if [[ ${dot_position} == ${i} ]]; then
    echo -ne "."
    fi
    echo -ne "${result:$i:1}"
done
echo ""
exit 0;
