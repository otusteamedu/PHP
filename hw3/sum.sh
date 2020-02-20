#!/bin/bash
if [ "$#" -ne 2 ]; then echo "need 2 number"; exit; fi
num1=$1
num2=$2
if [[ ! "$num1" =~ ^-?[0-9]+\.[0-9]+$|^-?[0-9]+$ ]]; then echo first param is not number; exit; fi
if [[ ! "$num2" =~ ^-?[0-9]+\.[0-9]+$|^-?[0-9]+$ ]]; then echo second param is not number; exit; fi

echo $num1 + $num2 |bc