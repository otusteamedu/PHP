#!/bin/sh

DATA_FILE=$1
FS=[[:space:]]

if [ ! $1 ]
then
  echo "Укажите файл с данными в параметре при вызове."
  exit
fi

if [ ! -f $DATA_FILE ]
then
  echo "Файл ${DATA_FILE} не найден."
  exit
fi

tail +2 $DATA_FILE | awk -F"${FS}" '{ total[$3]++ } END { for (i in total) print total[i], i }' | sort -nr | head -n 3  | sed 's/^.* //'
