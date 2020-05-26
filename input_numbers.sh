# !/bin/bash
echo Enter two numbers:;
read num1;
read num2;
echo "" | awk -v num1=$num1 -v num2=$num2 '{
  regexDigit = /[+-]?([0-9]*[.])?[0-9]+/
  conditionFirstAgrumentValid = (num1 != "" || num1 ~ regexDigit);
  conditionSecondAgrumentValid = (num2 != "" || num2 ~ regexDigit);
  if (!conditionFirstAgrumentValid && conditionSecondAgrumentValid) {
    print "Please enter valid first arguments"
  } else if (conditionFirstAgrumentValid && !conditionSecondAgrumentValid) {
    print "Please enter valid second arguments"
  } else if (!conditionFirstAgrumentValid && !conditionSecondAgrumentValid) {
    print "Please enter valid both arguments"
  } else {
    if (num1 < 0) { print num2+num1 } else { print num1+num2 }
  }
}';