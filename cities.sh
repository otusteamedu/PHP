#!/bin/bash

# есть ли имя файла во входном параметре

if [ -n "$1" ]
then
	filename=$1
else
	filename="users.txt"
fi

cat $filename | sed 1d | awk -F" " '{ print $3 }' | sort | uniq -c | sort -n -r -k 1 | head -3
