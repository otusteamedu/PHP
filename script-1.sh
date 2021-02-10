echo 'Введите первый аргумент'
read param1
echo 'Введите второй аргумент'
read param2
re="^\-?[0-9]*\.?[0-9]+$"


check1=`echo "$param1" | grep -E "$re"`
check2=`echo "$param2" | grep -E "$re"`

if [ "$check1" != '' ] && [ "$check2" != '' ]; then    
  echo "Результат:"  
  awk 'BEGIN {print ARGV[1] + ARGV[2]}' "$param1" "$param2"
else
  echo "Можно складывать только числа!"
  exit 1
fi
