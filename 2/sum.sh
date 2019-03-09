#!/bin/bash

if [ $# -ne 2 ]
    then
        echo "Incorrect count parametres"
    elif !(echo "$1" | grep -E -q "^?[0-9]+$") || ! (echo "$2" | grep -E -q "^?[0-9]+$");
        then 
            echo " Not Number"
        else
        
        sum=$(($1+$2))
    echo $sum;
fi
