# !/bin/bash
echo Enter two numbers:;
read num1;
read num2;
echo "" | awk -v num1=$num1 -v num2=$num2 '{ if (num1 != "" && num1 ~ /[+-]?([0-9]*[.])?[0-9]+/ && num2 != "" && num2 ~ /[+-]?([0-9]*[.])?[0-9]+/) { if (num1 < 0) { print num2+num1 } else if (num2 < 0) { print num1+num2 } else if (num1 > 0 || num2 > 0) { print num1+num2 } } else { print "Please try more with valida input numbers" } }';