#!/bin/bash
if [ "$#" -ne 1 ]; then echo "need filepath"; exit; fi
filepath=$PWD/$1;
if [[ -f $filepath ]]; then
cat $filepath |grep "[0-9]" | sort -k3 | awk -F" " '{ print $3}' | uniq -c |sort -rk1 | head -3 | awk -F" " '{ print $2}';
else
echo "file does not exist"; fi