checkNumber='^[+-]?[0-9]+([.][0-9]+)?$'
checkNot=true
while $checkNot
do
   read x
   read y
if [[ $x =~ $checkNumber ]] && [[ $y =~ $checkNumber ]]; 
then
    checkNot=false
    awk "BEGIN {print $x+$y; exit}"
else  
    echo "error: Not a numbers";
fi

done
