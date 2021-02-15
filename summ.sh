#!/bin/bash
param1=$1
param2=$2
 
reg_num='/^(\-?0*[1-9][0-9]*(\.[0-9]+)?|\-?0+\.[0-9]*[1-9][0-9]*)$/{print $0}'

echo "Параметр1=$param1, Параметр2=$param2"

while [[ $(echo "$param1" | awk "$reg_num") == "" ]]
do
echo "Требуется чтобы первый параметр был числом!!!"
read -p "Введите число->" param1
done

while [[ $(echo "$param2" | awk "$reg_num") == "" ]]
do
echo "Требуется чтобы второй параметр был числом!!!"
read -p "Введите число->" param2
done

# источник https://ru.stackoverflow.com/questions/553481/%D0%90%D1%80%D0%B8%D1%84%D0%BC%D0%B5%D1%82%D0%B8%D0%BA%D0%B0-%D1%81-%D0%BF%D0%BB%D0%B0%D0%B2%D0%B0%D1%8E%D1%89%D0%B5%D0%B9-%D1%82%D0%BE%D1%87%D0%BA%D0%BE%D0%B9
# в программе bash не реализована арифметика с плавающей точкой (только целочисленная).
# поэтому чтобы воспользоваться стандартной функцией необходимо разделить число на целую и дробную составляющие
# в дробной составляющей нужно иметь ввиду количество знаков и привести оба числа к одинаковому количеству разрядов
# сложить дроби и проверить разрядность (т.е. количество знаков) если она превышает на 1  999+999 = 1998 то прибавляем единицу к сумме целых составляющих числа
# и соответсвенно убираем старший разряд из дробной части. соединяем сумму целых и сумму дробных составляющих числа. выводим результат

# разделяем числа на целую и дробную части
param1_int=$(echo "$param1" | awk -F "." '{print $1}' )
param1_float=$(echo "$param1" | awk -F "." '{print $2}' )
param2_int=$(echo "$param2" | awk -F "." '{print $1}' )
param2_float=$(echo "$param2" | awk -F "." '{print $2}' )
# определяем длину дробных частей
param1_float_length=${#param1_float}
param2_float_length=${#param2_float}
digits_count=$(echo -e "$param1_float_length \n $param2_float_length" | sort -n -r | head -1 )
# пройдемся по всем цифрам дробной составляющей
for (( c=0; c<"$digits_count"; c++ ))
do
  digit1=$(echo ${param1_float:$c:1} | awk '{print $1} !$1 && $1 != 0 {print "0"} ') # если цифры нет, то вставляем 0
  digit2=$(echo ${param2_float:$c:1} | awk '{print $1} !$1 && $1 != 0 {print "0"} ') # если цифры нет, то вставляем 0
  # умножаем каждую цифру на 10 в степени ее порядкового номера с конца начиная с 0
  float1_digit=$(( digit1 * 10**(digits_count-c-1) ))
  float2_digit=$(( digit2 * 10**(digits_count-c-1) ))
  # вычисляем общую сумму дроби
  float_sum=$(( float_sum + $digit1 * 10**(digits_count-c-1) + $digit2 * 10**(digits_count-c-1) ))
done

# вычисляем значение до запятой
int_sum=$(( param1_int+param2_int ))

if [ "${#float_sum}" -gt "$digits_count" ]
then
  # если после запятой оказалось больше знаков чем в любом из чисел, то увеличиваем целое значение на 1
  # и слева уменьшаем разрядность на единицу (ту, которая ушла в целое)
  (( int_sum++ ))
  float_sum="${float_sum:1}"
else
  # если меньше, то нужно добавить нули
  difference_length=$(( "$digits_count" - "${#float_sum}"))
  while [ "$difference_length" != 0 ]; do
      float_sum="0$float_sum"
      (( difference_length-- ))
  done
fi
echo "Результат сложения двух чисел встроенными в Linux средствами:"
echo -e "Слагаемое1 = $param1, Слагаемое2 = $param2 и их сумма равна $int_sum.$float_sum\n"
echo "Результат сложения двух чисел используя библиотеку bc:"
sum=$(echo "$param1 + $param2" | bc)
echo "Слагаемое1 = $param1, Слагаемое2 = $param2 и их сумма равна $sum"
newsum=$(echo "$param1 $param2" | awk '{print $1+$2}')
echo "Результат сложения двух чисел используя библиотеку awk:"
echo "Слагаемое1 = $param1, Слагаемое2 = $param2 и их сумма равна $newsum"
exit 0
