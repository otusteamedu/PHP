#! /bin/bash
if [ ! $# -eq 2 ]
then
   echo 'Error: You should pass 2 parameters'
else 
    if [[ ( ! $1 =~ ^[-]?([0-9]*[.])?[0-9]+$ ) || ( ! $2 =~ ^[-]?([0-9]*[.])?[0-9]+$ ) ]]
     then
        echo "Error: You should pass numbers only"
    else
        echo $(awk "BEGIN {print $1+$2; exit}")
    fi
fi

