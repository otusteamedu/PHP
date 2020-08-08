re='^[+-]?[0-9]+([.][0-9]+)?$'
echo Введите два числа для суммирования:
read number1 number2

if ! [[ $number1 =~ $re ]] ; then
   echo "Error: First number is not a number"; exit 1
fi

if ! [[ $number2 =~ $re ]] ; then
   echo "Error: Second number is not a number"; exit 1
fi

echo $(echo "$number1+$number2" | bc -l)
