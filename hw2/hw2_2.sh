#!bin/bash
if [[ $# == 1 ]]
then
    inputfile=$1
    awk '{print$3}' $inputfile | sort | uniq -c | sort -r | awk '{print$2}'| head -n3
else
    echo 'Need filename as an argument'
fi
