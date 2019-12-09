#!/bin/bash
num1=$1
num2=$2
isValidNumber="^(\-)?([0-9]|0\.[0-9]+|[1-9]{1}[0-9]*\.?[0-9]+)$"
drobnoeRegex="^(\-)?([0-9]+)\.([0-9]+)"
zeroFirst="^(0+)([1-9][0-9]*)$"
num1DrobLength=0
num2DrobLength=0
maxDrobLength=0

if [[ $num1 == "" || $num2 == "" ]]; then
  printf 'Wrong format for program!\nThe right format is "./sum.sh -10.15 8.17"\n'
  exit 1
fi

if [[ ! $num1 =~ $isValidNumber ]]; then
  echo "Number1 $num1 has invalid format!"
  exit 1
fi

if [[ ! $num2 =~ $isValidNumber ]]; then
  echo "Number2 $num2 has invalid format!"
  exit 1
fi

if [[ $num1 =~ $drobnoeRegex ]]; then
  isMinus=${BASH_REMATCH[1]}
  firstPart=${BASH_REMATCH[2]}
  lastPart=${BASH_REMATCH[3]}
  num1DrobLength=${#BASH_REMATCH[3]}

  if [[ $lastPart =~ $zeroFirst ]]; then
    lastPart=${BASH_REMATCH[2]}
  fi

  ((num1 = firstPart * (10 ** num1DrobLength) + lastPart))
  if [[ $isMinus == '-' ]]; then
    ((num1 = 0 - num1))
  fi
fi

if [[ $num2 =~ $drobnoeRegex ]]; then
  isMinus=${BASH_REMATCH[1]}
  firstPart=${BASH_REMATCH[2]}
  lastPart=${BASH_REMATCH[3]}
  num2DrobLength=${#BASH_REMATCH[3]}

  if [[ $lastPart =~ $zeroFirst ]]; then
    lastPart=${BASH_REMATCH[2]}
  fi

  ((num2 = firstPart * (10 ** num2DrobLength) + lastPart))
  if [[ $isMinus == '-' ]]; then
    ((num2 = 0 - num2))
  fi
fi

if [[ $num1DrobLength -gt $num2DrobLength ]]; then
  ((num2 = num2 * (10 ** (num1DrobLength - num2DrobLength))))
  maxDrobLength=$num1DrobLength
elif [[ $num2DrobLength -gt $num1DrobLength ]]; then
  ((num1 = num1 * (10 ** (num2DrobLength - num1DrobLength))))
  maxDrobLength=$num2DrobLength
else
  maxDrobLength=$num1DrobLength
fi

((result = num1 + num2))

if [[ $maxDrobLength -ne 0 ]]; then
  isNegativeMask="^(\-)"
  isNegative=0
  if [[ $result =~ $isNegativeMask ]]; then
    isNegative=1
    ((result = 0 - result))
  fi
  ((firstPart = result / (10 ** maxDrobLength)))
  ((lastPart = result % (10 ** maxDrobLength)))
  if [[ isNegative -eq 1 ]]; then
    firstPart="-$firstPart"
  fi

  if [[ ${#lastPart} -lt maxDrobLength ]]; then
    ((zerosNeedToAdd = maxDrobLength - ${#lastPart}))
    while [ $zerosNeedToAdd -ne 0 ]; do
      lastPart="0$lastPart"
      ((zerosNeedToAdd -= 1))
    done
  fi

  result="$firstPart.$lastPart"
fi

echo $result
exit 0
