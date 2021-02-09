#!/usr/bin/bash
firstParam=$1
secondParam=$2
regex=^-?[0-9]+\(\.[0-9]+\)?$
if [[ "$firstParam" =~ $regex ]] && [[ "$secondParam" =~ $regex ]]
then
echo "$firstParam+$secondParam" | bc -l
exit 0
else
echo "Неправильный формат числа или не хватает данных"
exit 1
fi
