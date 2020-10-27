#!/bin/bash
# total=$[ $a + $b ]
while [[ -z $A ]]; do
	echo set first number:
	read A;
done

while [[ -z $B ]]; do
	echo set second number:
	read B;
done

reg='^[+-]?[0-9]+([.][0-9]+)?$';

# echo ${numberA}

if [[ $A == $reg ]] || [[ $B == $reg ]]; then
	echo only numbers needed;
	exit 0;
fi

echo "The sum is "
echo "$A + $B" | bc
exit 1
