#!/bin/bash

file=$1

if [[ $file == "" ]]; then
	echo "Вторым параметром укажите название файла count_cities.sh cities.txt"
	exit 1
fi


cat $file | grep -v 'id user city' | awk '{print $3}'| sort | uniq -c | sort -nrk1 | head -n 3
