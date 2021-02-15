regexp='^[+-]?[0-9]+([.][0-9]+)?$'
result=0
for arg in "$@"
do
if ! [[ $arg =~ $regexp ]]; then
echo "Error: The '$arg' argument is not a number" && exit;
fi
result=$(echo $result $arg | awk '{ result = $1 + $2; printf result }')
done
echo "The result is $result"
