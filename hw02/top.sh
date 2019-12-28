#!/bin/bash

file=$1;

if [[ $file == "" || ! -f $file ]]
then
  echo 'bad file';
  exit;
fi

cat -s $file | awk '$1 != "id" && $3 != "" {print $3}' | sort | uniq -c | sort -rnk1 | awk '{print $2}' | head -n 3
