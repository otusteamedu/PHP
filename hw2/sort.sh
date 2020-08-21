#!/bin/bash
file=$1

if [[ $file == *.txt ]] ; then 
	awk -F' ' '{print $3}' $file | tail -n+2 | sort | uniq -c | sort -gr
else
	echo "Неверный формат файла"
fi
